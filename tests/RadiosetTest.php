<?php

use McManning\Form\Radioset;

class RadiosetTest extends \PHPUnit_Framework_TestCase
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
        $binds = (new Radioset($this->renderer))
                    ->id('test-radioset')
                    ->name('test-radioset')
                    ->options([
                        'foo' => 'Foo label',
                        'bar' => 'Bar label'
                    ])
                    ->checked('foo')
                    ->label('Test Radioset')
                    ->binds();

        $firstElementBinds = $binds['elements'][0]->binds();

        $this->assertSame('test-radioset', $binds['id']);
        $this->assertSame('test-radioset', $binds['attributes']['name']);
        $this->assertSame('Test Radioset', $binds['label']);

        // Just check to see if it was created and we applied a checked attr
        // (actual unit testing of Radio is done in RadioTest)
        $this->assertSame(
            'type="radio" id="foo" name="foo" checked', 
            $firstElementBinds['attributesHtml']
        );
    }
}
