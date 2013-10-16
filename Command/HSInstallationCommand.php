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
            ->setDescription('Insert the language and domain entities defined in the configuration in the database');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->installLanguages($input, $output);
        $this->installDomains($input, $output);
    }
    
    protected function installLanguages(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Installing languages:');
        $languageManager = $this->getContainer()->get('hs_translation.manager.translation_language');
        $languages = $this->getContainer()->getParameter('hs_translation.languages');
        
        $count = 1;
        foreach ($languages as $code => $name) {
            if ($languageManager->addLanguage($code, $name, $count++)) {
                $output->writeln($name . ' installed.');
            } else {
                $output->writeln($name . ' already installed.');
            }
        }
        
        $output->writeln('The languages are now installed.');
    }
    
    protected function installDomains(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Installing domains:');
        $domainManager = $this->getContainer()->get('hs_translation.manager.translation_domain');
        $domains = $this->getContainer()->getParameter('hs_translation.domains');
        
        foreach ($domains as $domain => $name) {
            if ($domainManager->addDomain($domain, $name)) {
                $output->writeln($name . ' installed.');
            } else {
                $output->writeln($name . ' already installed.');
            }
        }
        
        $output->writeln('The domains are now installed.');
    }
}