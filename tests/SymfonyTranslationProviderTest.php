<?php

namespace Laasti\SymfonyTranslationProvider\Tests;

use Laasti\SymfonyTranslationProvider\SymfonyTranslationProvider;
use League\Container\Container;
use Symfony\Component\Translation\Translator;

class SymfonyTranslationProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testDefault()
    {
        $container = new Container();
        $container->addServiceProvider(new SymfonyTranslationProvider);
        $translator = $container->get('Symfony\Component\Translation\Translator');
        $this->assertTrue($translator instanceof Translator);
        $this->assertTrue($translator->trans('hello_world') === 'Hello');
    }

    public function testConfig()
    {
        $container = new Container();
        $container->add('config', [
            'translation' => [
                'locale' => 'fr',
                'resources' => [
                    'fr' => [
                        ['array', ['okay' => 'correct']]
                    ],
                    'en' => [
                        ['array', ['scared' => 'scaredy cat', 'okay' => 'okay']]
                    ],
                ]
            ]
        ]);
        $container->addServiceProvider(new SymfonyTranslationProvider);
        $translator = $container->get('Symfony\Component\Translation\Translator');
        $this->assertTrue($translator->trans('okay') === 'correct');
        $this->assertTrue($translator->trans('scared') === 'scaredy cat');
    }

}
