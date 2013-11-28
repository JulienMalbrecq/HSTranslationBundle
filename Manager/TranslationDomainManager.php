<?php

namespace HS\TranslationBundle\Manager;

use HS\TranslationBundle\Manager\TranslationManager;
use HS\TranslationBundle\Entity\TranslationDomain;

class TranslationDomainManager extends TranslationManager
{
    public function getDomainByName($name, $emptyOnNotFound = true)
    {
        $domain = $this->em
            ->getRepository('HSTranslationBundle:TranslationDomain')
            ->findOneBy(array('domain' => $name));
        
        if ($emptyOnNotFound && !$domain) {
            $domain = new TranslationDomain();
            $domain->setDomain((string)$name);
            $domain->setName(ucfirst((string)$name));
            $domain->setEnabled(true);
        }
        
        return $domain;
    }
    
    public function addDomain($domain, $name, $enabled = true)
    {
        $repository = $this->em->getRepository(
            'HSTranslationBundle:TranslationDomain'
        );
        
        //- check that the domain is not yet in the database
        $entity = $repository->findOneBy(array('domain' => $domain));
        if ($entity) {
            return;
        }

        //- create a new domain entity
        $newDomain = new TranslationDomain();
        $newDomain
            ->setDomain($domain)
            ->setName($name)
            ->setEnabled($enabled)
        ;

        //- persist it
        $this->em->persist($newDomain);
        $this->em->flush($newDomain);
        
        return true;
    }
}