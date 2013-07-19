<?php

namespace HS\TranslationBundle\Manager;

use Doctrine\ORM\EntityManager;

abstract class TranslationManager
{
    protected $em;
    
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}