<?php

namespace App\Repository;

use App\Entity\DocumentItem as DocumentItemEntity;
use App\Entity\InventoryError;
use App\Enum\Entity\DocumentType;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryError>
 */
class InventoryErrorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, InventoryError::class);
    }

    public function save(InventoryError $error): void
    {
        $this->getEntityManager()->persist($error);
        $this->getEntityManager()->flush();
    }

    public function findByDocumentItemId(string $documentItemId): ?InventoryError
    {
        return $this->findOneBy(['documentItemId' => $documentItemId]);
    }

    public function inventoryByDate(DateTime $date)
    {
        $endDate = (clone $date)->setTime(23, 59, 59);

        return $this->entityManager->getRepository(DocumentItemEntity::class)
            ->createQueryBuilder('di')
            ->innerJoin('di.document', 'd')
            ->where('d.type = :type')
            ->andWhere('d.createdAt BETWEEN :startDate AND :endDate')
            ->setParameters(new ArrayCollection([
                new Parameter('type', DocumentType::INVENTORY->value),
                new Parameter('startDate', $date),
                new Parameter('endDate', $endDate),

            ]))
            ->orderBy('d.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
