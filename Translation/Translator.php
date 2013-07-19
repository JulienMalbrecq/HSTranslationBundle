<?php

namespace HS\TranslationBundle\Translation;

use Symfony\Bundle\FrameworkBundle\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{
    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        if (null === $locale) {
            $locale = $this->getLocale();
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        if (!isset($this->catalogues[$locale])) {
            $this->loadCatalogue($locale);
        }

        if ($this->options['debug'] && !$this->catalogues[$locale]->has((string) $id, $domain)) {
            $updater = $this->container->get('hs_translation.translation.missing_translation_updater');
            $updater->insertTranslation($id, $domain);
        }
        
        return strtr($this->catalogues[$locale]->get((string) $id, $domain), $parameters);
    }
}