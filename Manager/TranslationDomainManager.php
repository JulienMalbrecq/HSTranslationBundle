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
}