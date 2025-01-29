<?php

namespace App\Controller\Items;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Item;
use App\Entity\Retailer;
use App\Entity\Size;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\ItemRepository;
use App\Repository\RetailerRepository;
use App\Repository\SizeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/items/manage', name: 'items.manage', methods: ['GET', 'POST'])]
final class ManageController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ItemRepository         $itemRepository,
        private readonly CategoryRepository     $categoryRepository,
        private readonly ImageRepository        $imageRepository,
        private readonly SizeRepository         $sizeRepository,
        private readonly RetailerRepository     $retailerRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $data = $request->request->all();
            $images = $request->files->get('image');

            $this->em->beginTransaction();

            foreach ($data['name'] ?? [] as $id => $quantity) {
                /** @var File $file */
                $file = $images[$id];

                $retailer = $this->findOrCreateNamedEntity(Retailer::class, $data['retailer'][$id]);
                $size = $this->findOrCreateNamedEntity(Size::class, $data['size'][$id]);
                $category = $this->findOrCreateNamedEntity(Category::class, $data['category'][$id]);

                if ($item = $this->itemRepository->find($id)) {
                    $item->link = $data['link'][$id];
                    $item->name = $data['name'][$id];
                    $item->category = $category;
                    $item->size = $size;
                    $item->retailer = $retailer;
                    $item->price = (float)$data['price'][$id];
                    $item->quantity = (int)$quantity;

                    if ($file) {
                        $item->image = $this->findOrCreateImage($file);
                    }
                } else {
                    $item = new Item(
                        name: $data['name'][$id],
                        link: $data['link'][$id],
                        category: $category,
                        size: $size,
                        retailer: $retailer,
                        price: (float)$data['price'][$id],
                        quantity: (int)$quantity,
                        image: $this->findOrCreateImage($file),
                    );
                }

                $this->em->persist($item);
            }

            foreach ($data['delete'] ?? [] as $id => $yes) {
                if ($item = $this->itemRepository->find($id)) {
                    $this->em->remove($item);
                }
            }

            $this->em->commit();
            $this->em->flush();

            return $this->redirectToRoute('items');
        }

        return $this->render(
            'items/manage.html.twig',
            [
                'categories' => $this->categoryRepository->findAll(),
                'retailers' => $this->retailerRepository->findAll(),
                'sizes' => $this->sizeRepository->findAll(),
                'items' => $this->itemRepository->findAll(),
            ],
        );
    }

    private function findOrCreateImage(File $file): Image
    {
        $image = $this->imageRepository->findOneBy([
            'hash' => $hash = md5(($mime = $file->getMimeType()) . ($content = base64_encode($file->getContent())))
        ]) ?? new Image(type: $mime, data: $content, hash: $hash);
        $this->em->persist($image);
        return $image;
    }

    /** @param class-string $entityClass */
    private function findOrCreateNamedEntity(string $entityClass, string $name): object
    {
        preg_match('/\\\(\w+)$/i', strtolower($entityClass), $matches);
        $repo = "$matches[1]Repository";

        $this->em->persist(
            $v = $this->$repo->findOneBy([
                'name' => $value = $name
            ]) ?? new $entityClass(name: $value)
        );
        return $v;
    }
}