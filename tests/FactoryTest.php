<?php

use McManning\Form\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
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

    /*
     * Create a basic text input element from a new factory
     */
    public function testCreateInput()
    {
        $factory = new Factory($this->renderer);

        $input = $factory->Input();

        $this->assertInstanceOf('McManning\Form\Input', $input);
    }

    /**
     * Test for class resolution laziness
     */
    public function testCaseInsensitivity()
    {
        $factory = new Factory($this->renderer);

        $input = $factory->iNPuT();

        $this->assertInstanceOf('McManning\Form\Input', $input);
    }
}
