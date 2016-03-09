<?php

namespace McManning\Form\Renderer;

use McManning\Form\Element;

/**
 * 
 */
interface RendererInterface
{
    public function render(Element $e);
}
