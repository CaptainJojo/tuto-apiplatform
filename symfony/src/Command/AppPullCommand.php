<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Google\Cloud\PubSub\PubSubClient;
use Psr\Log\LoggerInterface;

class AppPullCommand extends Command
{
    protected static $defaultName = 'app:pull';

    private $logger;
    private $pubSubClient;

    public function __construct(PubSubClient $pubSubClient, LoggerInterface $logger)
    {   
        $this->pubSubClient = $pubSubClient;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Pull le pub/sub')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $subscription = $this->pubSubClient->subscription('command');

        foreach ($subscription->pull() as $message) {
            $this->logger->info(json_decode($message->data()));
            $subscription->acknowledge($message);
        }

        $io->success('Pub/Sub vide');
    }
}
