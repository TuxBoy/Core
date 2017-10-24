<?php
namespace TuxBoy\Twig;

use Psr\Container\ContainerInterface;
use TuxBoy\Html\Menu;
use TuxBoy\Router\Router;

class MenuExtension extends \Twig_Extension
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->container = $container;
        $this->router    = $router;
    }

    /**
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('menuLinks', [$this, 'getLinkMenu'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @return string|null
     */
    public function getLinkMenu(): ?string
    {
        $output = '';
        if ($this->container->has('menu')) {
            $menus = array_map(function ($menu) {
                /** @var $menu Menu */
                return [$menu->getOrder() => $menu->build($this->router)];
            }, $this->container->get('menu'));
            asort($menus);
            foreach ($menus as $menu) {
                $output .= current($menu);
            }
            return $output;
        }
        return '';
    }
}
