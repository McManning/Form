<?php

namespace McManning\Form;

/**
 * Group of McManning\Form\Radio elements.
 * 
 * This provides shortcut methods for generating radio
 * buttons en-masse.
 *
 */
class Radioset extends Group
{
    /**
     * Set options (input[type=radio]) for this radioset
     *
     * Once set, the internal iterator will be reset to the beginning
     *
     * @param array[string] $options mapping input[name] => input[value]
     *
     * @return this
     */
    public function options(array $options)
    {
        $this->elements = [];
        foreach ($options as $k => $v) {
            (new Radio($this->renderer))
                ->id($k)
                ->name($k)
                ->label($v)
                ->group($this);
        }

        $this->rewind();
        return $this;
    }

    /**
     * Set the checked option.
     *
     * Checked option must exist in our options() array as a key
     *
     * @param string $value
     *
     * @return this
     */
    public function checked($value)
    {
        foreach ($this as $radio) {
            if ($radio->attributes['name'] === $value) {
                $radio->checked();
            }
        }

        return $this;
    }
}
