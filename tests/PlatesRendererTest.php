<?php

// Because PHP is retardo
date_default_timezone_set('America/New_York');

use League\Plates\Engine;
use McManning\Form\Renderer\PlatesRenderer;
use McManning\Form\Input;
use McManning\Form\Textarea;
use McManning\Form\Radioset;
use McManning\Form\Select;
use McManning\Form\Date;

class PlatesRendererTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->engine = new Engine();
        $this->engine->setFileExtension('phtml');
        $this->engine->addFolder('form', 'tests/fixtures/plates');

        $this->renderer = new PlatesRenderer($this->engine, 'form');
    }

    public function testInputTemplate()
    {
        $expected = <<<HTML
<div class="input-field">
    <input type="text" id="test-input" name="test" maxlength="50" value="test value" />
    <label for="test-input">Test</label>
    <p class="error"></p>
    <p class="help">Some help text</p>
</div>
HTML;
        $input = new Input($this->renderer);
        $input
            ->id('test-input')
            ->name('test')
            ->label('Test')
            ->maxlength(50)
            ->help('Some help text')
            ->value('test value');

        $actual = trim($input->render());

        $this->assertSame($expected, $actual);
    }

    /**
     * Test HTML injection in attributes 
     */
    public function testInputExploit()
    {
        $expected = <<<HTML
<div class="input-field">
    <input type="text" id="test-input" name="&quot; exploit1=&quot;" maxlength="&quot; exploit3=&quot;" value="&quot; exploit6=&quot;" />
    <label for="test-input">&quot; exploit2=&quot;</label>
    <p class="error">&quot; exploit5=&quot;</p>
    <p class="help">&quot; exploit4=&quot;</p>
</div>
HTML;
        $input = new Input($this->renderer);
        $input
            ->id('test-input')
            ->name('" exploit1="')
            ->label('" exploit2="')
            ->maxlength('" exploit3="')
            ->help('" exploit4="')
            ->error('" exploit5="')
            ->value('" exploit6="');

        $actual = trim($input->render());

        $this->assertSame($expected, $actual);
    }

    public function testTextareaTemplate()
    {
        $expected = <<<HTML
<div class="input-field">
    <textarea id="test-text" name="test" maxlength="50">test value</textarea>
    <label for="test-text">Test</label>
    <p class="error"></p>
    <p class="help">Some help text</p>
</div>
HTML;
        $textarea = new Textarea($this->renderer);
        $textarea
            ->id('test-text')
            ->name('test')
            ->label('Test')
            ->maxlength(50)
            ->help('Some help text')
            ->text('test value');

        $actual = trim($textarea->render());

        $this->assertSame($expected, $actual);
    }

    public function testRadiosetTemplate()
    {
        // I know, tabbing is weird. That's what you get when 
        // you do template injection :) Who cares what the actual
        // HTML output is.
        $expected = <<<HTML
<div id="test-radioset" name="test-radioset">
    <div class="input-field">
    <input type="radio" id="foo" name="foo" checked />
    <label for="foo">Foo label</label>
    <p class="error"></p>
    <p class="help"></p>
</div>
    <div class="input-field">
    <input type="radio" id="bar" name="bar" />
    <label for="bar">Bar label</label>
    <p class="error"></p>
    <p class="help"></p>
</div>
    <label for="test-radioset">Test Radioset</label>
    <p class="error"></p>
    <p class="help">Radioset sample</p>
</div>
HTML;
        $actual = trim((new Radioset($this->renderer))
                        ->id('test-radioset')
                        ->name('test-radioset')
                        ->options([
                            'foo' => 'Foo label',
                            'bar' => 'Bar label'
                        ])
                        ->checked('foo')
                        ->label('Test Radioset')
                        ->help('Radioset sample')
                    );

        $this->assertSame($expected, $actual);
    }

    public function testSelectTemplate()
    {
        $expected = <<<HTML
<div class="input-field">
    <select id="test-select" name="test">
            <option disabled>Select an option</option>
            <option selected value="foo">Foo</option>
            <option value="bar">Bar</option>
        </select>
    <label for="test-select">test input</label>
    <p class="error"></p>
    <p class="help">help text</p>
</div>
HTML;
        $actual = trim((new Select($this->renderer))
                        ->id('test-select')
                        ->name('test')
                        ->label('test input')
                        ->options([
                            '' => 'Select an option',
                            'foo' => 'Foo',
                            'bar' => 'Bar'
                        ])
                        ->help('help text')
                        ->selected('foo')
                        ->render()
                    );

        $this->assertSame($expected, $actual);
    }

    /**
     * Test DateTime conversion functionality of Date inputs
     */
    public function testDateTemplate()
    {
        $expected = <<<HTML
<div class="input-field">
    <input type="date" id="test-date" name="test" value="2016-12-01" />
    <label for="test-date">Test</label>
    <p class="error"></p>
    <p class="help">Some help text</p>
</div>
HTML;
        $input = new Date($this->renderer);
        $input
            ->id('test-date')
            ->name('test')
            ->label('Test')
            ->help('Some help text')
            ->value(new \DateTime('12/1/2016'));

        $actual = trim($input->render());

        $this->assertSame($expected, $actual);
    }
}
