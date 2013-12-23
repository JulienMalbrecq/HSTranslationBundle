<?php

namespace HS\TranslationBundle\Tests\Entity;

use HS\TranslationBundle\Entity\TranslationTerm;

class TranslationTermTest extends \PHPUnit_Framework_TestCase
{
    protected $term;
    
    public function setUp()
    {
        $this->term = new TranslationTerm();
    }
    
    public function testAddAndRemoveTranslationData()
    {
        //$data = $this->getMock('HS\TranslationBundle\Entity\TranslationData');
        
        $french = $this->getTranslationData('french');
        $english = $this->getTranslationData('english');
        
        $this->assertCount(0, $this->term->getTranslationData());
        
        $this->term->addTranslationData($french);
        $this->assertCount(1, $this->term->getTranslationData());
        
        $this->term->addTranslationData($english);
        $this->assertCount(2, $this->term->getTranslationData());
        
        // check that the data is not inserted twice
        $this->term->addTranslationData($english);
        $this->assertCount(2, $this->term->getTranslationData());
        
        // Check the removal of a translation data
        $this->assertCount(1, $this->term->removeTranslationData($english)->getTranslationData());
        
    }
    
    protected function getTranslationData($lang)
    {
        $translationData = $this->getMock('HS\TranslationBundle\Entity\TranslationData');
        $language = $this->getMock('HS\TranslationBundle\Entity\Language');
        
        $language
            ->expects($this->any())
            ->method('__toString')
            ->will($this->returnValue($lang));
        
        $translationData
            ->expects($this->any())
            ->method('getLanguage')
            ->will($this->returnValue($language));
        
        return $translationData;
    }
}
