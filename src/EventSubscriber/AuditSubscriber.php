<?php

namespace App\EventSubscriber;

use App\Services\AuditLogger;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\SerializerInterface;

class AuditSubscriber implements EventSubscriberInterface
{
    private const SKIP_ENTITIES = ['App\Entity\AuditLog', 'App\Entity\User'];

    public function __construct(
        private readonly AuditLogger $auditLogger,
        private readonly SerializerInterface $serializer,
        private array $removals = []
    ) {

    }

    public function getSubscribedEvents(): array
    {
        return [
            'postPersist',
            'postUpdate',
            'preRemove',
            'postRemove',
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'insert', $entityManager);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'update', $entityManager);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $this->removals[] = $this->serializer->normalize($entity);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'delete', $entityManager);
    }

    private function log($entity, string $action, EntityManagerInterface $em): void
    {
        $entityClass = get_class($entity);

        if (in_array($entityClass, self::SKIP_ENTITIES)) {
            return;
        }
        $entityId = $entity->getId();
        $entityType = str_replace('App\Entity\\', '', $entityClass);
        // The Doctrine unit of work keeps track of all changes made to entities.
        $uow = $em->getUnitOfWork();
        if ($action === 'delete') {
            // For deletions, we get our entity from the temporary array.
            $entityData = array_pop($this->removals);
            $entityId = $entityData['id'];
        } elseif ($action === 'insert') {
            // For insertions, we convert the entity to an array.
            $entityData = $this->serilizer->normalize($entity);
        } else {
            // For updates, we get the change set from Doctrine's Unit of Work manager.
            // This gives an array which contains only the fields which have
            // changed. We then just convert the numerical indexes to something
            // a bit more readable; "from" and "to" keys for the old and new values.
            $entityData = $uow->getEntityChangeSet($entity);
            foreach ($entityData as $field => $change) {
                $entityData[$field] = [
                    'from' => $change[0],
                    'to' => $change[1],
                ];
            }
        }
        $this->auditLogger->log($entityType, $entityId, $action, $entityData);
    }
}