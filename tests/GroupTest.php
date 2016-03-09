<?php

use McManning\Form\Group;
use McManning\Form\Hidden;

class GroupTest extends \PHPUnit_Framework_TestCase
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

    public function testAdd()
    {
        $group = (new Group($this->renderer))
                    ->id('test-group')
                    ->label('Some group')
                    ->help('Some help')
                    ->error('Some error');

        // Add some random elements to the group
        (new Hidden($this->renderer))
            ->name('hidden-1')
            ->group($group);
        
        (new Hidden($this->renderer))
            ->name('hidden-2')
            ->group($group);

        $binds = $group->binds();

        $secondElementBinds = $binds['elements'][1]->binds();

        $this->assertSame('test-group', $binds['id']);

        // Just check to see if it was created and we applied attributes
        // (actual unit testing of elements is done in their respective files)
        $this->assertSame(
            'type="hidden" name="hidden-2"', 
            $secondElementBinds['attributesHtml']
        );
    }
}
