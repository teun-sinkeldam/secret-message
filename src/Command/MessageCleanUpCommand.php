<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\MessageRepository;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// TODO: Use cronjob to run this command periodically
#[AsCommand(
    name: 'app:message:clean-up',
    description: 'Remove commands that were created before today',
)]
class MessageCleanUpCommand extends Command
{
    public function __construct(
        private readonly MessageRepository $messageRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $this->messageRepository->removeBeforeDate((new DateTimeImmutable())->setTime(0, 0, 0));

        $io->success('Expired messages removed!');

        return Command::SUCCESS;
    }
}
