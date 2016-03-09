<?php

use McManning\Form\Textarea;

class TextareaTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Set up a mock for our renderer
        $renderer = $this
            ->getMockBuilder('McManning\Form\Renderer\RendererInterface')
            ->getMock();

        $renderer->method('render')->willReturn('');

        $this->renderer = $renderer;
    }

    public function testBasicTextarea()
    {
        $expected = [
            'id' => 'test-textarea',
            'error' => '',
            'label' => '',
            'help' => '',
            'attributes' => [
                'id' => 'test-textarea',
                'name' => 'test-textarea'
            ],
            'attributesHtml' => 'id="test-textarea" name="test-textarea"',
            'text' => 'Sample text'
        ];

        $actual = (new Textarea($this->renderer))
                    ->id('test-textarea')
                    ->name('test-textarea')
                    ->text('Sample text')
                    ->binds();

        $this->assertSame($expected, $actual);
    }
}
