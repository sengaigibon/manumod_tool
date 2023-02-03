<?php

namespace App\Services;

use App\Entity\AuditLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;

class AuditLogger
{
    private EntityManagerInterface $em;
    private Security $security;
    private RequestStack $requestStack;

    public function __construct(EntityManagerInterface $entityManager, Security $security, RequestStack $requestStack)
    {
        $this->em = $entityManager;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function log(string $entityType, string $entityId, string $action, array $eventData): void
    {
        /** @var \App\Entity\User $user */
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();
        $log = new AuditLog;
        $log->setEntityType($entityType);
        $log->setEntityId($entityId);
        $log->setAction($action);
        $log->setEventData($eventData);
        $log->setUser($user);
        $log->setRequestRoute($request->get('_route'));
        $log->setIpAddress($request->getClientIp());
        $log->setCreatedAt(new \DateTimeImmutable);
        $this->em->persist($log);
        $this->em->flush();
    }
}