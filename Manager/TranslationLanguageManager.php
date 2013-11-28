<?php

namespace HS\translationBundle\Manager;

use HS\TranslationBundle\Manager\TranslationManager;

use HS\TranslationBundle\Entity\Language;

class TranslationLanguageManager extends TranslationManager
{
    
    public function addLanguage($code, $name, $weight = 0, $enabled = true)
    {
        $repository = $this->em->getRepository('HSTranslationBundle:Language');
        
        //- check that the language is not yet in database
        $lang = $repository->findOneBy(array('code' => $code));
        if ($lang) {
            return;
        }

        //- create a new language entity
        $newLanguage = new Language();
        $newLanguage
            ->setCode($code)
            ->setName($name)
            ->setWeight($weight)
            ->setEnabled($enabled)
        ;

        //- persist it
        $this->em->persist($newLanguage);
        $this->em->flush($newLanguage);
        
        return true;
    }
}