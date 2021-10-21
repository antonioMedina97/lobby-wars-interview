<?php

declare(strict_types=1);

namespace App\Infrastructure\CLI;

use Psr\Container\ContainerInterface;
use App\Infrastructure\Messaging\QueryBus;
use Symfony\Component\Console\Command\Command;
use App\Application\Service\QueryContractResolver;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ContractCommand extends Command
{
    public function __construct(private ContainerInterface $container, private QueryBus $queryBus, ?string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setName('contract');
        $this->setDescription('Contract Wars');

        $this->addArgument('contracts', InputArgument::REQUIRED, 'Contract to compare');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contract = $input->getArgument('contracts')
            ? explode(' vs ', $input->getArgument('contracts'))
            : null;

        try {
            $contractWinner = $this->queryBus->dispatch(QueryContractResolver::contractQuery($contract));
            $output->writeln((string) $contractWinner);

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            return Command::FAILURE;
        }
    }
}
