<?php

namespace Source\Command;

use Source\QueueHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QueueRunCommand extends Command
{
    protected function configure()
    {
        $this->setName('queue:run')
             ->setDescription('De-Queue and run a single queue item.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $qh = new QueueHelper();
        if ($qh->Queue()->count() > 0) {
            $qh->RunQueue();
            $output->writeln('Processed one queue item.');
        }
        else {
            $output->writeln('No queue items to process.');
        }
    }
}