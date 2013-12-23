<?php

namespace HS\TranslationBundle\Event;

final class TranslationEvents
{
    /**
     * The translation.missing_translation.request event is thrown each time
     * a translation that is not in the translation cache is requested.
     *
     * The event listener receives an
     * HS\TranslationBundle\Event\MissingTranslationEvent instance.
     *
     * @var string
     */
    const MISSING_TRANSLATION = 'translation.missing_translation.request';
}