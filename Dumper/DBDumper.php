<?php

namespace HS\TranslationBundle\Dumper;

use HS\TranslationBundle\Entity\TranslationDomain;
use HS\TranslationBundle\Manager\TranslationDomainManager;
use HS\TranslationBundle\Manager\TranslationTermManager;
use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\MessageCatalogue;

class DBDumper implements DumperInterface
{
    protected $domainManager;
    protected $termManager;
    
    function __construct(TranslationDomainManager $domainManager, TranslationTermManager $termManager)
    {
        $this->domainManager = $domainManager;
        $this->termManager = $termManager;
    }
    
    /**
     * {@inheritDoc}
     */
    public function dump(MessageCatalogue $messages, $options = array())
    {
        // save the domains
        foreach ($messages->getDomains() as $domain) {
            if (!$this->domainManager->domainExists($domain)) {
                $this->domainManager->addDomain($domain, ucfirst($domain), true);
            }
            
            $domainEntity = $this->domainManager->getDomainByName($domain);
            $this->processMessages($domainEntity, $messages->all($domain));
        }
        
    }
    
    protected function processMessages(TranslationDomain $domain, array $messages = array())
    {
        foreach ($messages as $name => $translation) {
            if ($this->termManager->termExists($name, $domain)) {
                continue;
            }
            
            $this->termManager->addBlankTerm($domain, $name, $translation);
        }
    }
}
