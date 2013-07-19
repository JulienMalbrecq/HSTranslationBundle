<?php

namespace HS\TranslationBundle\Translation;

/**
 * Clear the translation cache
 */

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Filesystem\Filesystem;

class TranslationCacheClearer
{
    private $cacheDir;
    private $filesystem;
    
    function __construct(Kernel $kernel, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->cacheDir = sprintf('%s/translations', $kernel->getCacheDir());
    }
    
    /**
     * Clear the translation cache
     * 
     * @return mixed Return true on success, null if no cache found
     */
    public function execute()
    {
        //- check that the translation cache exists
        if (!$this->filesystem->exists($this->cacheDir)) {
            return null;
        }
        
        $this->filesystem->remove($this->cacheDir);
        return true;
    }
}