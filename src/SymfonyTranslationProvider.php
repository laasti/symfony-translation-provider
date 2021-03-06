<?php

namespace Laasti\SymfonyTranslationProvider;

use League\Container\ServiceProvider;
use Symfony\Component\Translation\Translator;

class SymfonyTranslationProvider extends ServiceProvider\AbstractServiceProvider implements ServiceProvider\BootableServiceProviderInterface
{

    protected $defaultProvides = [
        'Symfony\Component\Translation\Translator',
        'Symfony\Component\Translation\Loader\LoaderInterface',
        'Laasti\SymfonyTranslationProvider\TranslationArray'
    ];
    protected $defaultConfig = [
        'locale' => 'en',
        'fallback_locales' => ['en'],
        'message_selector_class' => 'Symfony\Component\Translation\MessageSelector',
        'loaders' => [
            'array' => 'Symfony\Component\Translation\Loader\ArrayLoader'
        ],
        'resources' => [
            'en' => [
                ['array', ['hello_world' => 'Hello']]
            ]
        ],
    ];
    protected $config;

    public function register()
    {
        $di = $this->getContainer();

        $config = $this->getConfig();

        $di->add($config['message_selector_class']);

        foreach ($config['loaders'] as $name => $class) {
            $di->add($class);
            $di->add('translation.loader.' . $name, $class);
        }

        $di->add('Symfony\Component\Translation\Translator', function() use ($di, $config) {
            $selector = $di->get($config['message_selector_class']);
            $translator = new Translator($config['locale'], $selector);
            $translator->setFallbackLocales($config['fallback_locales']);
            foreach ($config['loaders'] as $name => $class) {
                $translator->addLoader($name, $di->get('translation.loader.' . $name));
            }
            foreach ($config['resources'] as $locale => $resources) {
                foreach ($resources as $config) {
                    list($loader, $arg, $domain) = $config + ['array', [], 'messages'];
                    $translator->addResource($loader, $arg, $locale, $domain);
                }
            }
            return $translator;
        }, true);
        $di->add('Laasti\SymfonyTranslationProvider\TranslationArray')->withArgument('Symfony\Component\Translation\Translator');
    }

    public function boot()
    {
        $this->getContainer()->inflector('Laasti\SymfonyTranslationProvider\TranslatorAwareInterface')
             ->invokeMethod('setTranslator', ['Symfony\Component\Translation\Translator']);
    }

    public function provides($alias = null)
    {
        if (empty($this->provides)) {
            $this->provides = $this->defaultProvides;
            $config = $this->getConfig();
            $this->provides[] = $config['message_selector_class'];

            foreach ($config['loaders'] as $loaderName => $loaderClass) {
                $this->provides[] = $loaderClass;
                $this->provides[] = 'translation.loader.' . $loaderName;
            }
        }
        if (! is_null($alias)) {
            return (in_array($alias, $this->provides));
        }
        return $this->provides;
    }

    protected function getConfig()
    {
        if (!is_null($this->config)) {
            return $this->config;
        }

        $di = $this->getContainer();
        if ($di->has('config') && isset($di->get('config')['translation'])) {
            $config = array_merge($this->defaultConfig, $di->get('config')['translation']);
        }
        $this->config = isset($config) ? $config : $this->defaultConfig;

        return $this->config;
    }

}
