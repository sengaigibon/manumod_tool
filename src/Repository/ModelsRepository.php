<?php

namespace App\Repository;

use App\Entity\Models;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Models>
 *
 * @method Models|null find($id, $lockMode = null, $lockVersion = null)
 * @method Models|null findOneBy(array $criteria, array $orderBy = null)
 * @method Models[]    findAll()
 * @method Models[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelsRepository extends ServiceEntityRepository
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Models::class);
    }

    public function save(Models $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Models $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Models[]
     */
    public function findParentCandidates(int $manufacturer, int $modelId): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.id != :modelId')
            ->andWhere('m.herst = :manufacturer')
            ->setParameter('modelId', $modelId)
            ->setParameter('manufacturer', $manufacturer)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findModelsCountByManufacturer(): array
    {
        $connection = $this->getEntityManager()->getConnection();
        return $connection->prepare("select h.name, count(mkm.id) as 'modelsCount' 
            from mdx_kfz_herst h join mdx_kfz_models mkm on h.id = mkm.herst 
            group by h.id order by modelsCount desc limit 15")
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function findModelsCountByTranslations(): array
    {
        $connection = $this->getEntityManager()->getConnection();
        return $connection->prepare("select concat(h.name, ' ', m.name) as name, count(mi.name) as 'modelsCount'
from mdx_kfz_models m join mdx_kfz_models_i18n mi on m.id = mi.modelId
    join mdx_kfz_herst h on m.herst = h.id
group by m.id
order by modelsCount desc
limit 5")
            ->executeQuery()
            ->fetchAllAssociative();
    }

    public function findLast(int $limit): ?array
    {
        return $this->createQueryBuilder('a')->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
