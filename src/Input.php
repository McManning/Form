<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Simple text input
 */
class Input extends Element
{
    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->type('text');
    }
}
