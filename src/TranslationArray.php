<?php

namespace Laasti\SymfonyTranslationProvider;

use Symfony\Component\Translation\Translator;

class TranslationArray
{

    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function __isset($name)
    {
        return true;
    }

    public function __get($name)
    {
        $domains = $this->translator->getCatalogue()->getDomains();

        if (in_array($name, $domains)) {
            return $this->translator->getCatalogue()->all($name);
        }

        return $this->translator->trans($name);
    }

    public function __invoke()
    {
        return $this;
    }
}