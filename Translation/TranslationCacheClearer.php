<?php

namespace HS\TranslationBundle\Translation;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Clear the translation cache
 */
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
     * Clear the translation cache directory
     * 
     * @throws Symfony\Component\Filesystem\Exception\IOException When removal fails
     * @return mixed Return null if no cache directory is found, true on success 
     */
    public function execute()
    {
        if (!$this->filesystem->exists($this->cacheDir)) {
            return null;
        }
        
        $this->filesystem->remove($this->cacheDir);
        return true;
    }
}