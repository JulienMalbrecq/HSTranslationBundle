<?php

namespace HS\TranslationBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Abstract class defining common classes used by managers
 */
abstract class TranslationManager
{
    protected $em;
    
    function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }
}