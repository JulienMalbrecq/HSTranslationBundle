<?php

namespace HS\TranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use HS\TranslationBundle\Entity\Language;
use HS\TranslationBundle\Entity\TranslationTerm;

/**
 * TranslationData
 *
 * @ORM\Table(name="translation_data")
 * @ORM\Entity
 */
class TranslationData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="translation", type="string")
     */
    private $translation;

    /**
     * @var Language
     * 
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", nullable=false)
     */
    private $language;
    
    /**
     * @var TranslationTerm
     * 
     * @ORM\ManyToOne(targetEntity="TranslationTerm", inversedBy="translationData")
     * @ORM\JoinColumn(name="term_id", referencedColumnName="id", nullable=false) 
     */
    private $term;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set translation
     *
     * @param string $translation
     * @return TranslationData
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;
    
        return $this;
    }

    /**
     * Get translation
     *
     * @return string 
     */
    public function getTranslation()
    {
        return $this->translation;
    }
    
    /**
     * Set language
     * 
     * @param Language $language
     * @return TranslationData
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Get language
     * 
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
     * Set translationTerm
     * 
     * @param TranslationTerm $term
     * @return TranslationData
     */
    public function setTerm(TranslationTerm $term)
    {
        $this->term = $term;
        return $this;
    }
    
    /**
     * Get translationTerm
     * 
     * @return TranslationTerm
     */
    public function getTerm()
    {
        return $this->term;
    }
    
    public function __toString()
    {
        return $this->getTranslation();
    }
}
