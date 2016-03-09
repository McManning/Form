<?php

namespace McManning\Form\Renderer;

use McManning\Form\Renderer\RendererInterface;
use McManning\Form\Element;

/**
 * Dummy to spit out a simple representation of the element being rendered
 *
 * Usage:
 * <code>
 *  $renderer = new DummyRenderer();
 *  $textarea = new Textarea($renderer);
 *  $textarea->maxlength(10)
 * </code>
 */
class DummyRenderer implements RendererInterface
{
    public function render(Element $e)
    {
        // Retrieve real classname from Element
        $class = join('', array_slice(explode('\\', get_class($e)), -1));

        // Dump some basic info about it
        return sprintf(
            "<%s label='%s' help='%s' error='%s' attributes='%s'>",
            $class,
            $e->label,
            $e->help,
            $e->error,
            json_encode($e->attributes)
        );
    }
}
