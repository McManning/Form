<?php

namespace McManning\Form\Renderer;

use League\Plates\Engine;
use McManning\Form\Renderer\RendererInterface;
use McManning\Form\Element;

/**
 * Usage: 
 * <code>
 *  $engine = new League\Plates\Engine(...);
 *  $engine->addFolder('form', '/path/to/form/views')
 *
 *  $renderer = new PlatesRenderer($engine, 'form');
 *  $textarea = new Textarea($renderer);
 *  $textarea->maxlength(10)->value('Hello');
 *  print $textarea; // Render /path/to/form/views/textarea.tpl
 * </code>
 */
class PlatesRenderer implements RendererInterface
{
    protected $engine;
    protected $folder;

    /**
     * @param League\Plates\Engine $engine
     * @param string $folder Plates folder for the template views.
     */
    public function __construct(Engine $engine, $folder)
    {
        $this->engine = $engine;
        $this->folder = $folder;
    }

    public function render(Element $e)
    {
        // Retrieve real classname from Element
        $class = join('', array_slice(explode('\\', get_class($e)), -1));

        // return $this->folder.'::'.$class;

        return $this->engine->render(
            $this->folder.'::'.$class,
            $e->binds()
        );
    }
}
