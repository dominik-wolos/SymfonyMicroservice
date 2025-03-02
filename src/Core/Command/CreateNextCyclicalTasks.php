<?php

declare(strict_types=1);

namespace App\Core\Command;

use App\Components\Task\Creator\CyclicalTaskCreatorInterface;
use App\Components\Task\Repository\TaskRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-next-cyclical-tasks',
    description: 'Create next cyclical tasks',
)]
final class CreateNextCyclicalTasks extends Command
{
    protected static $defaultName = 'app:create-next-cyclical-tasks';

    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly CyclicalTaskCreatorInterface $missingTasksCreator,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create next cyclical tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Creating next cyclical tasks...');
        $tasks = $this->taskRepository->findAllMainCyclical();

        if (null === $tasks || [] === $tasks) {
            $output->writeln('No tasks found');

            return Command::SUCCESS;
        }

        foreach ($tasks as $task) {
            try {
                $output->writeln(sprintf('Creating next cyclical tasks for task with id %d', $task->getId()));
                $this->missingTasksCreator->createTasks($task);
            } catch (\Throwable $e) {
                $output->writeln(sprintf('Error while creating tasks for task with id %d: %s', $task->getId(), $e->getMessage()));
            }
        }
        $output->writeln(sprintf('Creating completed'));

        return Command::SUCCESS;
    }
}
