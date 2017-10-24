<?php
namespace TuxBoy\Html;

use TuxBoy\Router\Router;

class BootstrapMenu extends Menu
{

    /**
     * @param Router $router
     * @return string
     */
    public function build(Router $router): string
    {
        $this->setSurroundTag('li', 'nav-link');
        return $this->surroundLink(
            '<a class="nav-link" href="'. $router->generateUri($this->getPath()) .'">'. $this->getLabel() .'</a>'
        );
    }
}
