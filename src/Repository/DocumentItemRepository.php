<?php

namespace App\Repository;

use App\Entity\DocumentItem;
use App\Enum\Entity\DocumentType;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DocumentItem>
 */
class DocumentItemRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, DocumentItem::class);
    }

    public function save(DocumentItem $item): void
    {
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
    }

    public function calculateStock(string $productId): int
    {
        $totalIncoming = $this->getStockByType($productId, DocumentType::INCOMING->value);
        $totalOutgoing = $this->getStockByType($productId, DocumentType::OUTGOING->value);

        return $totalIncoming - $totalOutgoing;
    }

    public function getStockByType(string $productId, string $type): int
    {
        $result = $this
            ->createQueryBuilder('di')
            ->select('SUM(di.quantity)')
            ->innerJoin('di.document', 'd')
            ->where('di.productId = :productId')
            ->andWhere('d.type = :type')
            ->setParameters(new ArrayCollection([
                new Parameter('productId', $productId),
                new Parameter('type', $type),
            ]))
            ->getQuery()
            ->getSingleScalarResult();

        return $result ?: 0;
    }

    /**
     * @return ?DocumentItem[]
     */
    public function findProductHistory(string $productId): ?array
    {
        return $this
            ->createQueryBuilder('di')
            ->innerJoin('di.document', 'd')
            ->where('di.productId = :productId')
            ->orderBy('d.createdAt', 'ASC')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getResult();
    }

    public function findIncomingDocumentItemsByDate(string $productId, DateTimeInterface $date): array
    {
        $startDate = (clone $date)->modify('-20 days');

        return $this
            ->createQueryBuilder('di')
            ->select('di.quantity, di.unitPrice')
            ->innerJoin('di.document', 'd')
            ->where('di.productId = :productId')
            ->andWhere('d.type = :type')
            ->andWhere('d.createdAt BETWEEN :startDate AND :endDate')
            ->setParameters(new ArrayCollection([
                new Parameter('productId', $productId),
                new Parameter('type', DocumentType::INCOMING->value),
                new Parameter('startDate', $startDate),
                new Parameter('endDate', $date),
            ]))
            ->getQuery()
            ->getResult();
    }

    public function findLastIncomingItem(string $productId): ?array
    {
        return $this
            ->createQueryBuilder('di')
            ->select('di.unitPrice')
            ->innerJoin('di.document', 'd')
            ->where('di.productId = :productId')
            ->andWhere('d.type = :type')
            ->orderBy('d.createdAt', 'DESC')
            ->setMaxResults(1)
            ->setParameters(new ArrayCollection([
                new Parameter('productId', $productId),
                new Parameter('type', DocumentType::INCOMING->value),
            ]))
            ->getQuery()
            ->getOneOrNullResult();
    }

}
