<?php

declare(strict_types=1);

namespace App\Api\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Api\DataProvider\DirectPlayerResourceInterface;
use App\Api\DataProvider\IndirectPlayerResourceInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Webmozart\Assert\Assert;

#[AutoconfigureTag('api_platform.doctrine.orm.query_extension.collection')]
#[AutoconfigureTag('api_platform.doctrine.orm.query_extension.item')]
final class CurrentPlayerQueryExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        if (!$this->isMainRequest($context)) {
            return;
        }

        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = []
    ): void {
        if (!$this->isMainRequest($context)) {
            return;
        }

        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (
            false === is_subclass_of($resourceClass, DirectPlayerResourceInterface::class)
            || $this->security->isGranted('ROLE_ADMIN')
            || null === $user = $this->security->getUser()
        ) {
            return;
        }

        if (
            false === is_subclass_of($resourceClass, IndirectPlayerResourceInterface::class) &&
            false === method_exists($resourceClass, 'getPlayerPropertyPathParts')
        ) {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.player = :player', $rootAlias));
            $queryBuilder->setParameter('player', $user->getId());

            return;
        }

        $propertyPathParts = $resourceClass::getPlayerPropertyPathParts();
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $previousAlias = $rootAlias;
        foreach ($propertyPathParts as $propertyPathPart) {
            if ($propertyPathPart === end($propertyPathParts)) {
                $queryBuilder->andWhere(sprintf('%s.player = :player', $previousAlias));
                break;
            }

            $queryBuilder->innerJoin(sprintf('%s.%s', $rootAlias, $propertyPathPart), $propertyPathPart);
            $previousAlias = $propertyPathPart;
        }
        $queryBuilder->setParameter('player', $user->getId());
    }

    private function isMainRequest(array $context): bool
    {

        $rootOperation = $context['root_operation'];
        Assert::isInstanceOf($rootOperation, Operation::class);

        if (
            $rootOperation instanceof Post
            || $rootOperation instanceof Patch
            || $rootOperation instanceof Put
        ) {
            return true;
        }

        if ($context['resource_class'] !== $rootOperation->getClass()) {
            return false;
        }

        return true;
    }
}
