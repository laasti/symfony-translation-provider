# Laasti/symfony-translation-provider

A league/container v2 service provider for Symfony's translation component.

## Installation

```
composer require laasti/symfony-translation-provider
```

## Usage

```php

$container = new League\Container\Container;
$container->addServiceProvider('Laasti\SymfonyTranslationProvider\SymfonyTranslationProvider');

$container->add('config.translation', [
    //Two-letter or four-letter locales are accepted
    'locale' => 'en',
    //When a message is not found in the locale, look in those too
    'fallback_locales' => ['en'],
    'message_selector_class' => 'Symfony\Component\Translation\MessageSelector',
    //Symfony's package offers many different loaders
    'loaders' => [
        'array' => 'Symfony\Component\Translation\Loader\ArrayLoader',
        'json' => 'Symfony\Component\Translation\Loader\JsonFileLoader'
    ],
    'resources' => [
        'en' => [
            //The first item is the loader to use, the second the resource the loader will use
            ['array', ['hello_world' => 'Hello']]
            //The third item in array is the resource's domain
            //Sseful to namespace messages, defaults to messages
            ['json', 'my-json-file.json', 'forms']
        ]
    ],
]);

$translator = $container->get('Symfony\Component\Translation\Translator');

$translator->trans('hello_world); //returns "Hello"

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

See Github's releases, or tags

## Credits

Author: Sonia Marquette (@nebulousGirl)

## License

Released under the MIT License. See LICENSE.txt file.