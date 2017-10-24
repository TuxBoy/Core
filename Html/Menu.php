<?php
namespace TuxBoy\Html;

use TuxBoy\Router\Router;

/**
 * Class Menu
 */
class Menu implements MenuInterface
{

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $surroundTag = 'li';

    /**
     * @var int
     */
    private $order;

    /**
     * Menu constructor.
     * @param string $label
     * @param string $path
     * @param int    $order
     */
    public function __construct(string $label, string $path, int $order = null)
    {
        $this->label = $label;
        $this->path  = $path;
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function surroundLink(string $link): string
    {
        if (is_null($this->surroundTag)) {
            return $link;
        }
        return '<'. $this->surroundTag .'>' . $link . '<' . $this->surroundTag . '/>';
    }

    /**
     * @param Router $router
     * @return string
     */
    public function build(Router $router): string
    {
        return $this->surroundLink(
            '<a href="'. $router->generateUri($this->getPath()) .'">'. $this->getLabel() .'</a>'
        );
    }

    /**
     * @param $surroundTag string
     */
    public function setSurroundTag(string $surroundTag)
    {
        $this->surroundTag = $surroundTag;
    }

    /**
     * @return int|null
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }
}
