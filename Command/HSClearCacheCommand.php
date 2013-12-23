<?php

namespace HS\TranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HSClearCacheCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('hs:translation:clear-cache')
            ->setDescription('Clear the translation cache');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('hs_translation.cache.clearer')->execute();
        $kernel = $this->getContainer()->get('kernel');
        
        $message = sprintf(
            'Translation cache cleared for the <info>%s</info> environment',
            $kernel->getEnvironment()
        );
        
        $output->writeln($message);
    }
}
