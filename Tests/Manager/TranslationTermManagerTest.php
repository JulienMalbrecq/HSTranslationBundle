<?php

namespace HS\TranslationBundle\Tests\Manager;

use HS\TranslationBundle\Manager\TranslationTermManager;

class TranslationTermManagerTest extends \PHPUnit_Framework_TestCase
{   
    public function testGetEmptyTerm()
    {
        $manager = new TranslationTermManager($this->getOMWithLanguageSupport());
        $domain = $this->getMock('HS\TranslationBundle\Entity\TranslationDomain');
        
        $this->assertInstanceOf('HS\TranslationBundle\Entity\TranslationTerm', $manager->getEmptyTerm());
    }
    
    public function testTermExists()
    {
        $manager = new TranslationTermManager($this->getOMWithTermSupport());
        $domain = $this->getMock('HS\TranslationBundle\Entity\TranslationDomain');
        $this->assertFalse($manager->termExists('test', $domain));
        $this->assertTrue($manager->termExists('test', $domain));
        
    }
 
    public function testAddBlankTerm()
    {
        $om = $this->getOm();
        $termRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        $termRepository
            ->expects($this->at(0))
            ->method('findOneBy')
            ->will($this->returnValue(null));
        
        $om->expects($this->at(0))
            ->method('getRepository')
            ->with('HSTranslationBundle:TranslationTerm')
            ->will($this->returnValue($termRepository));
        
        $om->expects($this->at(1))
           ->method('getRepository')
           ->with('HSTranslationBundle:Language')
           ->will($this->returnValue($this->getLanguageRepository()));
        
        $manager = new TranslationTermManager($om);
        $domain = $this->getMock('HS\TranslationBundle\Entity\TranslationDomain');
        
        $term = $manager->addBlankTerm($domain, 'name', 'translation');
        $this->assertInstanceOf('HS\TranslationBundle\Entity\TranslationTerm', $term);
    }
    
    protected function getOm()
    {
        $om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        return $om;
    }
    
    protected function getLanguageRepository()
    {
        $language = $this->getMock('HS\TranslationBundle\Entity\Language');
        $languageRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        $languageRepository
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue(array($language)));
        
        return $languageRepository;
    }
    
    protected function getOMWithLanguageSupport()
    {
        $om = $this->getOm();
        
        $om->expects($this->any())
            ->method('getRepository')
            ->with('HSTranslationBundle:Language')
            ->will($this->returnValue($this->getLanguageRepository()));
        
        return $om;
    }
    
    protected function getOMWithTermSupport()
    {
        $om = $this->getOm();
        $term = $this->getMock('HS\TranslationBundle\Entity\TranslationTerm');
        
        $termRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();
        
        $termRepository
            ->expects($this->at(0))
            ->method('findOneBy')
            ->will($this->returnValue(null));
        
        $termRepository
            ->expects($this->at(1))
            ->method('findOneBy')
            ->will($this->returnValue($term));
        
        $om->expects($this->any())
            ->method('getRepository')
            ->with('HSTranslationBundle:TranslationTerm')
            ->will($this->returnValue($termRepository));
        
        return $om;
    }
}
