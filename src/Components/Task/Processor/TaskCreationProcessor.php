<?php

declare(strict_types=1);

namespace App\Components\Task\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Provider\CurrentPlayerProvider;
use App\Components\Task\Creator\TaskRewardCreatorInterface;
use App\Components\Task\Dictionary\TaskStates;
use App\Components\Task\Dictionary\TaskTypes;
use App\Components\Task\Entity\TaskInterface;
use Webmozart\Assert\Assert;

final class TaskCreationProcessor implements TaskCreationProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly TaskRewardCreatorInterface $taskRewardCreator,
        private readonly CurrentPlayerProvider $currentPlayerProvider,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, TaskInterface::class);

        $task = $data;

        $task->setPlayer($this->currentPlayerProvider->provide($operation, $uriVariables, $context));
        Assert::notNull($task->getPlayer());

        $this->taskRewardCreator->create($task);

        switch ($task->getType()) {
            case TaskTypes::ONE_TIME:
            case TaskTypes::RECURRING:
                $task->setStatus(TaskStates::ACCEPTED);

                break;
            case TaskTypes::CHALLENGE:
                $task->setStatus(TaskStates::ACCEPTED);

                break;
            default:
                throw new \InvalidArgumentException('Invalid task type');
        }

        return $this->processor->process($task, $operation, $uriVariables, $context);
    }
}
