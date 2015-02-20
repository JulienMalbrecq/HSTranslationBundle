<?php

namespace HS\TranslationBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MissingTranslationEvent extends Event
{
    private $id;
    private $domain;
    
    function __construct($id, $domain)
    {
        $this->id = (string)$id;
        $this->domain = (string)$domain;
    }
    
    /**
     * Get the term id
     * 
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the translation domain
     * 
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
