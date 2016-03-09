<?php

date_default_timezone_set('America/New_York');
require __DIR__ . '/vendor/autoload.php';

$widgets = [];

$widgets['input'] = 
    (new McManning\Form\Input())
        ->id('my-input')
        ->name('my-input')
        ->class('foo', 'bar')
        ->error('Something went wrong')
        ->required()
        ->data('foo', 'bar')
        ->data('foo2', 'more bars')
        ->label('Some sort of input')
        ->maxlength(100)
        ->help('Some sort of additional help text');

$widgets['textarea'] = 
    (new McManning\Form\Textarea())
        ->id('something')
        ->name('something')
        ->label('Some sort of textarea')
        ->maxlength(120)
        ->required()
        ->help('Some sort of help text')
        ->text('Hi Gfro');

$widgets['date'] = 
    (new McManning\Form\Date())
        ->id('some-date')
        ->name('some-date')
        ->value(new \DateTime());


$widgets['select'] = 
    (new McManning\Form\Select())
        ->id('test-select')
        ->options([
            '' => 'Select an option',
            'foo' => 'Foo',
            'bar' => 'Bar'
        ]);

$widgets['checkbox'] = 
    (new McManning\Form\Checkbox())
        ->id('test-checkbox')
        ->checked()
        ->label('Some checkbox');

$widgets['radio'] = 
    (new McManning\Form\Radio())
        ->id('test-radio')
        ->name('test-radioset')
        ->checked()
        ->label('Some radio');

$widgets['group'] =
    (new McManning\Form\Group())
        ->id('test-group')
        ->label('Some group')
        ->help('Some help')
        ->error('Some error');

    // Add some shizz to the group
    (new McManning\Form\Radio())
        ->id('test-radio1')
        ->name('test-radio1')
        ->group($widgets['group'])
        ->label('Some radioset');

    (new McManning\Form\Radio())
        ->id('test-radio2')
        ->name('test-radio2')
        ->checked()
        ->group($widgets['group'])
        ->label('Group of radios');

// Shortcut for the above
$widgets['radioset'] = 
    (new McManning\Form\Radioset())
        ->id('test-radioset')
        ->name('my-radioset')
        ->options([
            'foo' => 'Foo label',
            'bar' => 'Bar label'
        ])
        ->checked('foo')
        ->label('My Radioset');


// Dump all widgets
foreach ($widgets as $type => $widget) {
    print '<h1>'.$type . "</h1>\n\n";
    print $widget . "\n\n";
}
