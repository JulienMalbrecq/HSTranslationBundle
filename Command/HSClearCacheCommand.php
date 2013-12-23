<?php

namespace HS\TranslationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HSInstallationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('hs:translation:install')
            ->setDescription('Insert in the database the languages and domains defined in the configuration');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->insertLanguages($input, $output);
        $this->insertDomains($input, $output);
        $this->insertFiles($input, $output);
    }
    
    /**
     * Insert in the database the translation languages
     * defined in the configuration
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function insertLanguages(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inserting languages:');
        $languageManager = $this->getContainer()->get('hs_translation.manager.translation_language');
        $languages = $this->getContainer()->getParameter('hs_translation.languages');
        
        $count = 1;
        foreach ($languages as $code => $name) {
            if ($languageManager->addLanguage($code, $name, $count++)) {
                $output->writeln($name . ' inserted');
            } else {
                $output->writeln($name . ' already inserted');
            }
        }
        
        $output->writeln('The languages are now inserted');
    }
    
    /**
     * Insert in the database the translation domains
     * defined in the configuration
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function insertDomains(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inserting domains:');
        $domainManager = $this->getContainer()->get('hs_translation.manager.translation_domain');
        $domains = $this->getContainer()->getParameter('hs_translation.domains');
        
        foreach ($domains as $domain => $name) {
            if ($domainManager->addDomain($domain, $name)) {
                $output->writeln($name . ' inserted');
            } else {
                $output->writeln($name . ' already inserted');
            }
        }
        
        $output->writeln('The domains are now inserted');
    }
    
    /**
     * Insert in the database the translation domains
     * defined in the configuration
     * 
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function insertFiles(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Inserting translation files:');
        $fileManager = $this->getContainer()->get('hs_translation.manager.translation_file');
        $domains = $this->getContainer()->getParameter('hs_translation.domains');
        
        foreach ($domains as $domain => $name) {
            $fileManager->ensureTranslationFile($domain);
        }
        
        $output->writeln('The translation files are now created ');
    }
}