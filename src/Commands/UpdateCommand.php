<?php

namespace Buonzz\NoIP\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Ip;
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
        // welcome
        $output->writeln('<comment>Welcome to client:update command</comment>');

        try {
            $client = new Client();
            $output->write('*** trying to detect your IP... ');
            $ip = file_get_contents('http://icanhazip.com/');
            $ip = str_replace(array("\r", "\n"), '', $ip);

            $validator = Validation::createValidator();
            $violations = $validator->validate($ip, array(
                new Ip(),
            ));

            if (count($violations) > 0) {
                // invalid IP
                $output->writeln('<error>Invalid IP. Nothing done.</error>');
            } else {
                // valid IP
                $output->writeln('<info>'.$ip.'</info>');
                $output->write('*** updating remote IP... ');
                // update IP
                $res = $client->update($ip);
                if ($res == 'OK') {
                    $output->writeln('<info>success!</info>');
                } else {
                    $output->writeln('<error>a problem has occured!</error> '.$res);
                }
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Unable to open Client connection. Nothing done.</error>');
        }
    }
}
