<?php

namespace App\Controller\Items;

use App\Entity\Item;
use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/items/add', name: 'items.add', methods: ['GET','POST'])]
final class AddController extends AbstractController
{
    public function __construct(
        private readonly ItemRepository $itemRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            $data = $request->request->all();

            $this->em->beginTransaction();

            foreach ($data['delete'] ?? [] as $id => $yes) {
                if ($item = $this->itemRepository->find($id)) {
                    $this->em->remove($item);
                }
            }

            $images = $request->files->get('image');

            foreach ($data['quantity'] ?? [] as $id => $quantity) {
                $item = $this->itemRepository->find($id);

                if ($item) {
                    $item->quantity += (int) $quantity;
                } else {
                    /** @var File $file */
                    $file = $images[$id];
                    $this->em->persist(
                        new Item(
                            number: $data['number'][$id],
                            image: base64_encode($file->getContent()),
                            quantity: (int) $quantity,
                            category: $this->categoryRepository->find($data['category'][$id]),
                            size: $data['size'][$id],
                            price: (float) $data['price'][$id],
                            name: $data['name'][$id],
                            imageType: $file->getMimeType(),
                        )
                    );
                }
            }

            $this->em->commit();
            $this->em->flush();

            return $this->redirectToRoute('items.list');
        }

        return $this->render(
            'items/add.html.twig',
            [
                'categories' => $this->categoryRepository->findAll(),
                'items' => $this->itemRepository->findAll(),
            ],
        );
    }
}