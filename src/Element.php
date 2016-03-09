<?php

namespace McManning\Form;

use McManning\Form\Renderer\RendererInterface;

/**
 * Common structure of a form element.
 *
 * All form elements share a particular set of properties;
 * an id, displayed label, displayed help text, displayed error,
 * attributes attached to the primary DOM element, and potentially
 * a group of elements that they belong to (e.g. a checkbox in a set)
 */
abstract class Element
{
    /**
     * Additional attributes applied to the element
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Error displayed on the element
     *
     * @var string
     */
    protected $error = '';

    /**
     * Additional help text to render next to the element
     *
     * @var string
     */
    protected $help = '';

    /**
     * Label to render next to the element
     *
     * @var string
     */
    protected $label = '';

    /**
     * Element ID
     *
     * @var string
     */
    protected $id = '';

    /**
     * Group containing this element
     *
     * @var McManning\Form\Group
     */
    protected $group = null;

    /**
     * @var McManning\Form\Renderer\RendererInterface
     */
    protected $renderer = null;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Print out the field.
     *
     * @return string
     */
    public function render()
    {
        return $this->renderer->render($this);
    }

    /**
     * Add unknown methods as element attributes.
     *
     * If parameters is a single boolean true, the attribute is
     * added with no value (equivalent to parameters being empty).
     * This is ideal for attributes like `checked`, `readonly`,
     * `disabled`, etc. Boolean false as input, however, will unset
     * the attribute specified by the method.
     *
     * Example:
     *      ->checked() is equivalent to ->checked(true)
     *      ->checked(false) will remove the checked attr
     *
     * @return this
     */
    public function __call($method, array $parameters)
    {
        if (count($parameters) === 1 && $parameters[0] === false) {
            unset($this->attributes[$method]);
        } else {
            $this->attributes[$method] = implode(' ', $parameters);
        }

        return $this;
    }

    /**
     * Print out the field. Shortcut for $this->render()
     *
     * @return string
     */
    public function __toString()
    {
        // Try-catch is here as PHP does not allow __toString
        // to throw exceptions. So instead, we convert it to
        // a string before throwing.
        try {
            return (string)$this->render();
        } catch (\Exception $e) {
            return (string)$e;
        }
    }

    public function id($value)
    {
        $this->id = $value;
        $this->attributes['id'] = $value;
        return $this;
    }

    /**
     * Set the label for the element
     *
     * @var string
     *
     * @return this
     */
    public function label($value)
    {
        $this->label = $value;
        return $this;
    }

    /**
     * Set the error message for the element
     *
     * @var string
     *
     * @return this
     */
    public function error($value)
    {
        $this->error = $value;
        return $this;
    }

    /**
     * Set the help message for the element
     *
     * @var string
     *
     * @return this
     */
    public function help($value)
    {
        $this->help = $value;
        return $this;
    }

    /**
     * Binds to apply to the template during render.
     *
     * Override to implement additional binds for an inherited
     * element that may contain additional (unique) properties
     *
     * @return array
     */
    public function binds()
    {
        return [
            'id' => $this->id,
            'error' => $this->error,
            'label' => $this->label,
            'error' => $this->error,
            'help' => $this->help,
            'attributes' => $this->attributes,
            'attributesHtml' => $this->attributesHtml()
        ];
    }

    /**
     * Map data-attr to a value.
     *
     * This is here because we can't utilize magic methods due
     * to the dash, and to make it explicit that these are setting
     * special HTML5 data attributes.
     *
     * @param string $attr data attribute name, without the `data-` prefix
     * @param string $value to set
     *
     * @return this
     */
    public function data($attr, $value)
    {
        $this->attributes['data-'.$attr] = $value;
        return $this;
    }

    /**
     * Add this element to a Group
     *
     * @param McManning\Form\Group $group
     *
     * @return this
     */
    public function group(Group $group)
    {
        $group->add($this);
        return $this;
    }

    /**
     * Convert internal attributes to HTML element attributes
     *
     * Example:
     * <code>
     *   // Call chain
     *   ->class('foo', 'bar')->value('foo')->disabled()
     *
     *   // Resulting string
     *   class="foo bar" value="foo" disabled
     * </code>
     *
     * @return string
     */
    protected function attributesHtml()
    {
        $attributes = [];
        foreach ($this->attributes as $k => $v) {
            if (empty($v)) {
                $attributes[] = $k;
            } else {
                $attributes[] = $k.'="'.
                    htmlspecialchars(
                        $v,
                        ENT_QUOTES | ENT_SUBSTITUTE,
                        'UTF-8'
                    ).'"';
            }
        }

        return implode(' ', $attributes);
    }
}
