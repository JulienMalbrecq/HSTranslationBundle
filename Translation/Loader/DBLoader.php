<?php
namespace HS\TranslationBundle\Translation\Loader;

use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Doctrine\ORM\EntityManager;

class DBLoader implements LoaderInterface
{
    private $em;
    
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
 
    function load($resource, $locale, $domain = 'messages')
    {
        $catalogue = new MessageCatalogue($locale);
        
        //Load on the db for the specified local
        $languageEntity = $this->em->getRepository('HSTranslationBundle:Language')
            ->findOneBy(array(
                'code' => $locale,
                'enabled' => true,
            ));
        
        if (!$languageEntity) {
            return $catalogue;
        }
        
        $domainEntity = $this->em->getRepository('HSTranslationBundle:TranslationDomain')
            ->findOneBy(array(
                'domain' => $domain,
                'enabled' => true,
            ));
        
        if (!$domainEntity) {
            return $catalogue;
        }
        
        $terms = $this->em->getRepository('HSTranslationBundle:TranslationTerm')
            ->findBy(array(
                'domain' => $domainEntity,
            ));
        
        if (!$terms) {
            return $catalogue;
        }
        
        $translations = $this->em->getRepository('HSTranslationBundle:TranslationData')
            ->findBy(array(
                'language' => $languageEntity,
                'term' => $terms,
            ));
        
        foreach($translations as $translation) {
            $catalogue->set(
                $translation->getTerm()->getMachineName(),
                $translation->getTranslation(),
                $domain
            );
        }
        return $catalogue;
    }
}
