<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Simple radio
 * 
 * As should be expected, radio groups are specified
 * by the `name` attribute.
 */
class Radio extends Input
{
    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->type('radio');
    }
}
