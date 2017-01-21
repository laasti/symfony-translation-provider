<?php

namespace Laasti\SymfonyTranslationProvider;

trait TranslatorAwareTrait
{
    /**
     * Symfony Translator
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;

    /**
     * Translate the id using the translator
     *
     * @param string $id The message id
     * @param array params An array of parameters for the message
     * @param string|null $domain The domain for the message
     * @param string|null $locale The locale
     * @return string The translated string
     */
    public function trans($id, $params = [], $domain = null, $locale = null)
    {
        return $this->getTranslator()->trans($id, $params, $domain, $locale);
    }

    /**
     * Get Translator instance
     * @return \Symfony\Component\Translation\Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * Set translator instance
     * @param \Symfony\Component\Translation\Translator $translator
     * @return \Symfony\Component\Translation\Translator
     */
    public function setTranslator(\Symfony\Component\Translation\Translator $translator)
    {
        $this->translator = $translator;
        return $this->translator;
    }
}
