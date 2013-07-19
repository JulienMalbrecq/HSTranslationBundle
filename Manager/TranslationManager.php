<?php

namespace HS\TranslationBundle\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Abstract class defining common classes used by managers
 */
abstract class TranslationManager
{
    protected $em;
    
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}