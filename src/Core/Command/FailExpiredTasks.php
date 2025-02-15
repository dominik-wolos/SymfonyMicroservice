<?php

declare(strict_types=1);

namespace App\Core\Command;

use App\Components\Task\Creator\CyclicalTaskCreatorInterface;
use App\Components\Task\Manager\TaskManagerInterface;
use App\Components\Task\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:fail-expired-tasks',
    description: 'Fail expired tasks',
)]
final class FailExpiredTasks extends Command
{
    protected static $defaultName = 'app:fail-expired-tasks';

    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly TaskManagerInterface $taskManager,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Fail expired tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $output->writeln('Failing tasks...');
        $tasks = $this->taskRepository->findAllExpiredTasks();

        if ($tasks === null || [] === $tasks) {
            $output->writeln('No tasks found');
            return Command::SUCCESS;
        }

        foreach ($tasks as $task) {
            try {
                $output->writeln(sprintf('Failing task with id %d', $task->getId()));
                $this->taskManager->fail($task);
                $this->entityManager->persist($task);
            } catch (\Throwable $e) {
                $output->writeln(sprintf('Error while failing tasks for task with id %d: %s', $task->getId(), $e->getMessage()));
            }
        }
        try {
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            $output->writeln(sprintf('Error while flushing: %s', $e->getMessage()));
        }

        $output->writeln(sprintf('Failing completed'));

        return Command::SUCCESS;
    }
}
