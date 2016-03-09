<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * HTML5 date input.
 *
 * For browsers that do not support input[type=date], 
 * a polyfill Javascript library is used to provide
 * a date picker.
 */
class Date extends Input
{
    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->type('date');
    }

    /**
     * Setting input value from a DateTime
     *
     * This will extract the date as YYYY-MM-DD as default value
     *
     * @param \DateTime $date
     *
     * @return this
     */
    public function value(\DateTime $date)
    {
        $this->attributes['value'] = $date->format('Y-m-d');
        return $this;
    }
}
