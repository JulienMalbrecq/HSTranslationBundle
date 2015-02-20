<?php

namespace HS\TranslationBundle\Translation;

use Symfony\Bundle\FrameworkBundle\Translation\Translator as BaseTranslator;

use HS\TranslationBundle\Event\TranslationEvents;
use HS\TranslationBundle\Event\MissingTranslationEvent;

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
            $event = new MissingTranslationEvent($id, $domain);
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch(TranslationEvents::MISSING_TRANSLATION, $event);
        }
        
        return strtr($this->catalogues[$locale]->get((string) $id, $domain), $parameters);
    }
}
