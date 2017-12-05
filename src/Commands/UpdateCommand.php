<?php

namespace Buonzz\NoIP\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Buonzz\NoIP\Client;

/**
 * Class UpdateCommand
 */
class UpdateCommand extends Command
{
    /**
     * Configure
     */
    protected function configure()
    {
        $this
            ->setName('client:update')
            ->setDescription('Detect and submit your current IP to NoIP.com');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();

        $output->writeln("Trying to detect your IP...");

        $ip = file_get_contents('http://icanhazip.com/');

        $output->writeln("Your IP is:".$ip);

        $output->writeln("Submitting to NoIP.com...");

//        $res = $client->update($ip);
//
//        if ($res == 'OK') {
//            $output->writeln("Done Updating.. Success!");
//        } else {
//            $output->writeln("A problem has occured! DDNS was not updated.".$res);
//        }
    }
}
