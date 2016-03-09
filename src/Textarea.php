<?php

namespace McManning\Form;

class Textarea extends Element
{
    protected $text = '';

    /**
     * Textarea text (DOM child of <textarea>)
     *
     * @param string $value
     *
     * @return this
     */
    public function text($value)
    {
        $this->text = $value;
        return $this;
    }

    public function binds()
    {
        return array_merge(parent::binds(), [
            'text' => $this->text
        ]);
    }

    // public function render()
    // {
    //     $html = '<div class="input-field">' .
    //                 '<textarea '.$this->attributesHtml().'>' .
    //                     $this->text . 
    //                 '</textarea>' .
    //                 '<label for="'.$this->id.'">' . 
    //                     $this->label . 
    //                 '</label>' .
    //                 '<p class="error">'.$this->error.'</p>' .
    //                 '<p class="help">'.$this->help.'</p>' .
    //             '</div>';
    //     return $html;
    // }
}
