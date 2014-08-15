<?php

namespace HS\TranslationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use HS\TranslationBundle\Entity\TranslationDomain;
use HS\TranslationBundle\Entity\TranslationData;

/**
 * TranslationTerm
 *
 * @ORM\Table(
 *      name="translation_term",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="machine_domain_uidx", columns={"machine_name", "domain_id"})},
 *      indexes={@ORM\Index(name="machine_idx", columns={"machine_name", "enabled"})}
 * )
 * @ORM\Entity
 */
class TranslationTerm
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
     * @ORM\Column(name="machine_name", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     */
    private $machineName;

    /**
     * @var TranslationDomain
     * 
     * @ORM\ManyToOne(targetEntity="TranslationDomain", cascade={"persist"})
     * @ORM\JoinColumn(name="domain_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     */
    private $domain;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var TranslationData
     * 
     * @ORM\OneToMany(targetEntity="TranslationData", mappedBy="term", cascade={"persist"})
     */
    private $translationData;

    
    function __construct()
    {
        $this->translationData = new ArrayCollection();
    }
    
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
     * Set machineName
     *
     * @param string $machineName
     * @return TranslationTerm
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;
    
        return $this;
    }

    /**
     * Get machineName
     *
     * @return string 
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * Set domain
     * 
     * @param TranslationDomain $domain
     * @return TranslationTerm;
     */
    public function setDomain(TranslationDomain $domain)
    {
        $this->domain = $domain;
        return $this;
    }
    
    /**
     * get domain
     * 
     * @return TranslationDomain
     */
    public function getDomain()
    {
        return $this->domain;
    }
    
    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return TranslationTerm
     */
    public function setEnabled($enabled = true)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * Get the translation datas
     * 
     * @return ArrayCollection
     */
    public function getTranslationData()
    {
        return $this->translationData;
    }
    
    /**
     * Set translation data
     * 
     * @param ArrayCollection $translationData
     * @return TranslationTerm
     */
    public function setTranslationData(ArrayCollection $translationData)
    {
        $this->translationData = $translationData;
        return $this;
    }
    
    /**
     * Add a translation data
     * 
     * @param TranslationData $data
     * @return TranslationTerm
     */
    public function addTranslationData(TranslationData $data)
    {
        if (!$this->translationData->contains($data)
            && !$this->hasDefinedLanguage($data->getLanguage())) {
            $this->translationData->add($data);
        }
        
        return $this;
    }
    
    /**
     * Remove a translation data
     * 
     * @param TranslationData $data
     * @return TranslationTerm
     */
    public function removeTranslationData(TranslationData $data) 
    {
        if ($this->translationData->contains($data)) {
            $this->translationData->removeElement($data);
        }
        
        return $this;
    }
    
    public function getDefinedLanguages()
    {
        return array_map(function (TranslationData $data) {
            return $data->getLanguage();
        }, $this->translationData->toArray());
    }
    
    public function hasDefinedLanguage(Language $language)
    {
        return in_array(
            $language,
            $this->getDefinedLanguages()
        );
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getMachineName();
    }
}
