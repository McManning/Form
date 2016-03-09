<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Simple hidden input
 */
class Hidden extends Element
{
    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->type('hidden');
    }
}
