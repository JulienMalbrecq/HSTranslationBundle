<?php

namespace HS\TranslationBundle\Translation;

use Doctrine\ORM\EntityManager;

use HS\TranslationBundle\Manager\TranslationDomainManager;
use HS\TranslationBundle\Manager\TranslationTermManager;

class MissingTranslationUpdater
{
    private $em;
    private $domainManager;
    private $termManager;
    
    function __construct(EntityManager $em, TranslationDomainManager $domainManager, TranslationTermManager $termManager)
    {
        $this->em = $em;
        $this->domainManager = $domainManager;
        $this->termManager = $termManager;
    }
    
    public function insertTranslation($id, $domain)
    {
        //- get the domain
        $domainEntity = $this->domainManager->getDomainByName($domain);

        //- check that the term doesn't already exists
        if ($this->termManager->termExists($id, $domainEntity)) {
            return;
        }
        
        //- create a new term
        $term = $this->termManager->getEmptyTerm();
        $term->setDomain($domainEntity);
        $term->setMachineName((string)$id);
        $term->setEnabled();

        $translationString = sprintf('__%s', (string)$id);
        foreach ($term->getTranslationData() as $translation)
        {
            $translation->setTranslation($translationString);
        }
        $this->em->persist($term);

        //- insert in db
        $this->em->flush();
    }
}