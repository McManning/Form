<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Simple checkbox
 */
class Checkbox extends Input
{
    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->type('checkbox');
    }
}
