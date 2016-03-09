
# Forms!

A lightweight approach for implementing form widget abstraction within PHP applications. 

## Installation

Via Composer:
```
{
    "repositories": [
        {
            "url": "https://github.com/McManning/Form.git",
            "type": "git"
        }
    ],
    "require": {
        "mcmanning/form": "dev-master"
    }
}
```

## Usage

### For users of [league/plates](https://github.com/thephpleague/plates)

Add a folder to your Plates Engine for your widget templates (check out `tests/fixtures/plates` for example implementations):
```php
$engine = new League\Plates\Engine();
$engine->addFolder('form', '/path/to/element/templates');
```

Create a new instance of `Form\Renderer\PlatesRenderer`, injecting the Plates Engine as a dependency as well as the folder name of your templates:
```php
$renderer = new Renderer\PlatesRenderer($engine, 'form');
```

Use that renderer as a dependency for new widgets:
```php
$myInput = new Input($renderer);
$myInput
    ->id('my-input')
    ->name('myInput')
    ->maxlength(100)
    ->value('Hello World');

print $myInput;
```

Alternatively, if doing dependency injection for every widget isn't your style, you can use `Form\Factory` to perform injection once, and carry forward with all new widgets from that factory:
```php
$factory = new Factory($renderer);

print $factory->input()
        ->id('my-input')
        ->name('myInput');
```

## Testing
```
$ phpunit
```

## Contributing

Pull requests welcome.

## License

The MIT License (MIT): https://opensource.org/licenses/MIT
