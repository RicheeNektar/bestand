<?php

namespace App\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class MenuItemsExtension extends AbstractExtension
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {
    }

    /** @return TwigFunction[] */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('menuItems', [$this, '__invoke']),
        ];
    }

    public function __invoke(): array
    {
        $routes = [];

        foreach ($this->router->getRouteCollection()->all() as $name => $route) {
            if (preg_match('#^/[^/]+$#i', $route->getPath())) {
                $routes[] = $name;
            }
        }

        return $routes;
    }
}