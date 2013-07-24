<?php

namespace HS\TranslationBundle\Event;

use Doctrine\ORM\EntityManager;

use HS\TranslationBundle\Manager\TranslationDomainManager;
use HS\TranslationBundle\Manager\TranslationTermManager;

use HS\TranslationBundle\Event\MissingTranslationEvent;

class MissingTranslationListener
{
    private $em;
    private $domainManager;
    private $termManager;
    private $bypassedDomains;
    private $enabled;
    
    function __construct(
        EntityManager $em,
        TranslationDomainManager $domainManager,
        TranslationTermManager $termManager,
        $bypassedDomains = array(),
        $enabled = false)
    {
        $this->em = $em;
        $this->domainManager = $domainManager;
        $this->termManager = $termManager;
        $this->bypassedDomains = $bypassedDomains;
        $this->enabled = $enabled;
    }
    
    /**
     * Missing translation event handler.
     * 
     * @param \HS\TranslationBundle\Event\MissingTranslationEvent $event
     */
    public function onEvent(MissingTranslationEvent $event)
    {
        if (!in_array($event->getDomain(), $this->bypassedDomains)
            && $this->enabled) {
            $this->insertTranslation($event->getId(), $event->getDomain());
        }
    }
    
    /**
     * Insert a missing term in the database.
     * 
     * @param string $id
     * @param string $domain
     * @return null
     */
    private function insertTranslation($id, $domain)
    {
        $domainEntity = $this->domainManager->getDomainByName((string)$domain);

        if (!$this->termManager->termExists($id, $domainEntity)) {
            $term = $this->termManager->getEmptyTerm();
            $term->setDomain($domainEntity)
                ->setMachineName((string)$id)
                ->setEnabled();

            $translationString = sprintf('__%s', (string)$id);
            $term->getTranslationData()->map(
                function ($translation) use ($translationString) {
                    $translation->setTranslation($translationString);
                }
            );
            
            $this->em->persist($term);
            $this->em->flush();
        }
    }
}