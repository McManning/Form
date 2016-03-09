<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Container of multiple arbitrary Elements
 *
 * A group is not much more than a div with it's own 
 * help/label/error display fields. A group may contain
 * any set of additional elements. 
 *
 * Rendering a group will cascade render all contained elements.
 *
 */
class Group extends Element implements \Iterator
{
    /**
     * Elements contained within this group
     *
     * @var array[Element]
     */
    protected $elements = [];

    /**
     * Iterator position of the group
     *
     * @var integer
     */
    protected $position = 0;

    public function __construct(RendererInterface $renderer)
    {
        parent::__construct($renderer);
        $this->position = 0;
    }

    /**
     * @see \Iterator::rewind
     */
    function rewind() 
    {
        $this->position = 0;
    }

    /**
     * @see \Iterator::current
     */
    function current() 
    {
        return $this->elements[$this->position];
    }

    /**
     * @see \Iterator::key
     */
    function key() 
    {
        return $this->position;
    }

    /**
     * @see \Iterator::next
     */
    function next() 
    {
        ++$this->position;
    }

    /**
     * @see \Iterator::valid
     */
    function valid() 
    {
        return isset($this->elements[$this->position]);
    }

    /**
     * Add an element to the group. 
     *
     * @param McManning\Form\Element $element to add
     *
     * @return this
     */
    public function add(Element $element)
    {
        $this->elements[] = $element;
        $element->group = $this;
        return $this;
    }

    public function binds()
    {
        return array_merge(parent::binds(), [
            'elements' => $this->elements
        ]);
    }
}
