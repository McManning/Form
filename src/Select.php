<?php

namespace McManning\Form;

/**
 *
 *
 */
class Select extends Element
{
    /**
     * Selected option value (key in $this->options)
     *
     * @var string
     */
    protected $selected = '';

    /**
     * Mapping of option[value] to display text
     *
     * @var array[string]
     */
    protected $options = [];

    /**
     * Set <option> elements for the select.
     *
     * Array keys are option[name], and values are the child DOM
     * If an option does not contain a value for option[name], it
     * is marked as a disabled option (thus placeholder)
     *
     * @param array[string] $options
     *
     * @return this
     */
    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Set the selected option.
     *
     * Selected option must exist in our options() array as a key
     *
     * @param string $value
     *
     * @return this
     */
    public function selected($value)
    {
        $this->selected = $value;
        return $this;
    }

    public function binds()
    {
        return array_merge(parent::binds(), [
            'options' => $this->options,
            'selected' => $this->selected
        ]);
    }

    /**
     * Returns HTML containing all <option> children of this select
     *
     * @return string
     */
    protected function optionsHtml()
    {
        $html = '';
        foreach ($this->options as $k => $v) {

            $attrs = [];
            if ($this->selected === $k) {
                $attrs[] = 'selected';
            }

            // Options without a value are disabled
            if (!empty($k)) {
                $attrs[] = 'value="'.$k.'"';
            } else {
                $attrs[] = 'disabled';
            }

            $html .= '<option '.implode(' ', $attrs).'>'.$v.'</option>';
        }

        return $html;
    }
}
