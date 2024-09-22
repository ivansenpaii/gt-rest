<?php

namespace App\Service;

use App\DTO\Request\Document\CreateDocument as CreateDocumentDto;
use App\Entity\Document as DocumentEntity;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\Exception as DoctrineException;
use Doctrine\ORM\EntityManagerInterface;

readonly class DocumentService
{
    public function __construct(
        private DocumentRepository $documentRepository,
        private EntityManagerInterface $entityManager,
        private DocumentItemService $documentItemService,
    ) {
    }

    /**
     * @throws DoctrineException
     */
    public function createDocument(CreateDocumentDto $requestDto): string
    {
        try {
            $this->entityManager->getConnection()->beginTransaction();

            $document = (new DocumentEntity())
                ->setType($requestDto->type);

            $this->documentRepository->save($document);
            foreach ($requestDto->items as $item) {
                $this->documentItemService->createDocumentItem($item, $document);
            }

            $this->entityManager->getConnection()->commit();
        } catch (DoctrineException $e) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->getConnection()->rollBack();
            }
            throw $e;
        }

        return $document->getId();
    }
}
