<?php

use McManning\Form\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
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

    public function testBasic()
    {
        $expected = [
            'id' => 'test-select',
            'error' => '',
            'label' => 'test input',
            'help' => 'help text',
            'attributes' => [
                'id' => 'test-select',
                'name' => 'test'
            ],
            'attributesHtml' => 'id="test-select" name="test"',
            'options' => [
                '' => 'Select an option',
                'foo' => 'Foo',
                'bar' => 'Bar'
            ],
            'selected' => ''
        ];

        $actual = (new Select($this->renderer))
                    ->id('test-select')
                    ->name('test')
                    ->label('test input')
                    ->options([
                        '' => 'Select an option',
                        'foo' => 'Foo',
                        'bar' => 'Bar'
                    ])
                    ->help('help text')
                    ->binds();

        $this->assertSame($expected, $actual);
    }

    /**
     * Test explicit change of the selected option
     */
    public function testSelectedOption()
    {
        $expected = [
            'id' => 'test-select',
            'error' => '',
            'label' => '',
            'help' => '',
            'attributes' => [
                'id' => 'test-select',
                'name' => 'test'
            ],
            'attributesHtml' => 'id="test-select" name="test"',
            'options' => [
                '' => 'Select an option',
                'foo' => 'Foo',
                'bar' => 'Bar'
            ],
            'selected' => 'foo'
        ];

        $actual = (new Select($this->renderer))
                    ->id('test-select')
                    ->name('test')
                    ->options([
                        '' => 'Select an option',
                        'foo' => 'Foo',
                        'bar' => 'Bar'
                    ])
                    ->selected('foo')
                    ->binds();

        $this->assertSame($expected, $actual);
    }
}
