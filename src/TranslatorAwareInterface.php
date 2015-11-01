<?php

namespace Laasti\SymfonyTranslationProvider;

interface TranslatorAwareInterface
{
    /**
     * Get Translator instance
     * @return \Symfony\Component\Translation\Translator
     */
    public function getTranslator();

    /**
     * Set translator instance
     * @param \Symfony\Component\Translation\Translator $translator
     * @return \Symfony\Component\Translation\Translator
     */
    public function setTranslator(\Symfony\Component\Translation\Translator $translator);


    /**
     * Translate the id using the translator
     *
     * @param string $id The message id
     * @param array params An array of parameters for the message
     * @param string|null $domain The domain for the message
     * @param string|null $locale The locale
     * @return string The translated string
     */
    public function trans($id, $params = [], $domain = null, $locale = null);
}
