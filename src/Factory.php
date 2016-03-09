<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Basic factory class for constructing form elements.
 *
 * This is an abstraction layer that handles dependency
 * injection for all form elements, thus relieving the
 * end user developer from having to specify DI's for
 * each element (unless they want to).
 *
 * Example:
 * <code>
 *  $formFactory = new FormFactory($dep1, $dep2)
 *  $formFactory->textarea()
 *      ->id('something')
 *      ->maxlength(120)
 *      ->value('Hello World');
 * </code>
 */
class Factory
{
    /**
     * @var McManning\Form\Renderer\RendererInterface
     */
    protected $renderer = null;

    /**
     * Create a new element factory
     *
     * @param McManning\Form\Renderer\RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Construct an element through the factory.
     *
     * Method name will map to McManning\Form\[method]
     *
     * @throws \ReflectionException if the element cannot be constructed
     *                              through the factory (i.e. does not exist)
     */
    public function __call($method, array $args)
    {
        // Push the renderer as the first argument to elements
        array_unshift($args, $this->renderer);

        // Construct a new element from the calling method
        $reflectionClass = new \ReflectionClass('McManning\\Form\\'.$method);
        return $reflectionClass->newInstanceArgs($args);
    }
}
