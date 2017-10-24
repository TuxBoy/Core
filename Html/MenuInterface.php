<?php
namespace TuxBoy\Html;

use TuxBoy\Router\Router;

interface MenuInterface
{

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param Router $router
     * @return string
     */
    public function build(Router $router): string;
}
