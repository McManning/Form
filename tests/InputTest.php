<?php

use McManning\Form\Input;

class InputTest extends \PHPUnit_Framework_TestCase
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

    public function testBasicInput()
    {
        $expected = [
            'id' => 'my-input',
            'error' => '',
            'label' => '',
            'help' => '',
            'attributes' => [
                'type' => 'text',
                'id' => 'my-input'
            ],
            'attributesHtml' => 'type="text" id="my-input"'
        ];

        $actual = (new Input($this->renderer))
                    ->id('my-input')
                    ->binds();

        $this->assertSame($expected, $actual);
    }

    /**
     * Test applying additional attributes to the input element
     */
    public function testAttributes()
    {
        $expected = [
            'id' => 'my-input',
            'error' => '',
            'label' => 'test input',
            'help' => 'help text',
            'attributes' => [
                'type' => 'text',
                'id' => 'my-input',
                'name' => 'my-input',
                'class' => 'foo bar',
                'required' => '',
                'length' => '100'
            ],
            'attributesHtml' => 'type="text" id="my-input" name="my-input" class="foo bar" required length="100"'
        ];

        $actual = (new Input($this->renderer))
                    ->id('my-input')
                    ->name('my-input')
                    ->class('foo', 'bar')
                    ->required()
                    ->label('test input')
                    ->length(100)
                    ->help('help text')
                    ->binds();

        $this->assertSame($expected, $actual);
    }

    /**
     * Test applying data attributes to the input element
     * 
     * This is different from normal attributes as we auto-prefix 
     * with `data-` to get around the issue of having methods called `data-foo()`
     */
    public function testDataAttributes()
    {
        $expected = [
            'id' => 'my-input',
            'error' => '',
            'label' => '',
            'help' => '',
            'attributes' => [
                'type' => 'text',
                'id' => 'my-input',
                'data-foo' => 'bar',
                'data-fizz' => 'buzz'
            ],
            'attributesHtml' => 'type="text" id="my-input" data-foo="bar" data-fizz="buzz"'
        ];

        $actual = (new Input($this->renderer))
                    ->id('my-input')
                    ->data('foo', 'bar')
                    ->data('fizz', 'buzz')
                    ->binds();

        $this->assertSame($expected, $actual);
    }

    /**
     * Test unsetting a previously set attribute
     */
    public function testUnsetAttribute()
    {
        $expected = [
            'id' => 'my-input',
            'error' => '',
            'label' => '',
            'help' => '',
            'attributes' => [
                'type' => 'text',
                'id' => 'my-input'
            ],
            'attributesHtml' => 'type="text" id="my-input"'
        ];

        $input = (new Input($this->renderer))
                    ->id('my-input')
                    ->required();

        $input->required(false);
        $actual = $input->binds();

        $this->assertSame($expected, $actual);
    }
}
