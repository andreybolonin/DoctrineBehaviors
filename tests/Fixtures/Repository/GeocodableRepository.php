<?php

declare(strict_types=1);

namespace Knp\DoctrineBehaviors\Tests\Fixtures\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Knp\DoctrineBehaviors\Contract\Entity\GeocodableInterface;
use Knp\DoctrineBehaviors\Tests\Fixtures\Entity\GeocodableEntity;

final class GeocodableRepository
{
    /**
     * @var ObjectRepository|EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(GeocodableEntity::class);
    }

    public function findOneByTitle(string $title): GeocodableInterface
    {
        return $this->repository->findOneBy(['title' => $title]);
    }
}
