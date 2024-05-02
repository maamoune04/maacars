<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

class UserFilterQueryCollectionExtension implements QueryCollectionExtensionInterface
{

    public function __construct(private readonly Security $security){}

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        // If the user is an admin, we don't filter the reservations
        if ($this->security->isGranted('ROLE_ADMIN'))
        {
            return;
        }

        // filter the reservations by the user connected
        if ($resourceClass === Reservation::class)
        {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.user = :user_connected', $rootAlias));
            $queryBuilder->setParameter('user_connected', $this->security->getUser()->getId());
        }

        // filter the users by the user connected
        if ($resourceClass === User::class)
        {
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(sprintf('%s.id = :user_connected', $rootAlias));
            $queryBuilder->setParameter('user_connected', $this->security->getUser()->getId());
        }

    }
}