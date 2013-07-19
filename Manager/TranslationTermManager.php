<?php

namespace HS\TranslationBundle\Manager;

use HS\TranslationBundle\Manager\TranslationManager;

use HS\TranslationBundle\Entity\TranslationDomain;
use HS\TranslationBundle\Entity\TranslationTerm;
use HS\TranslationBundle\Entity\TranslationData;

/**
 * Manage the creation 
 */
class TranslationTermManager extends TranslationManager
{
    public function getEmptyTerm()
    {
        $term = new TranslationTerm();
        $this->attachTranslationData($term);
        return $term;
    }
    
    public function attachTranslationData(TranslationTerm &$term)
    {
        $languages = $this->em
            ->getRepository('HSTranslationBundle:Language')
            ->findBy(array('enabled' => true));
        
        foreach ($languages as $language) {
            $localizedTerm = new TranslationData();
            $localizedTerm->setTerm($term);
            $localizedTerm->setLanguage($language);
            $term->addTranslationData($localizedTerm);
        }
    }
    
    public function termExists($name, TranslationDomain $domain)
    {
        return !!$this->em->getRepository('HSTranslationBundle:TranslationTerm')
            ->findOneBy(array(
                'machineName' => (string) $name,
                'domain' => $domain
            ));
    }
}