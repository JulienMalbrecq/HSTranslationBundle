<?php

namespace HS\TranslationBundle\Manager;

class TranslationFileManager
{
    private $languages;
    private $translationDirectory;
    
    function __construct($languages, $translationDirectory)
    {
        $this->languages = $languages;
        $this->translationDirectory = $translationDirectory;
        if (!file_exists($translationDirectory)) {
            mkdir($translationDirectory, 0755, true);
        }
    }
    
    public function ensureTranslationFile($domain)
    {
        foreach ($this->languages as $code => $name)
        {
            $file = sprintf(
                '%s/%s.%s.db', $this->translationDirectory, $domain, $code
            );
            
            if (!file_exists($file)) {
                touch($file);
            }
        }
    }
}
