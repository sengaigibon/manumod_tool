<?php

namespace App\Repository;

use App\Entity\Country;
use App\Entity\ModelCountriesRelation;
use App\Entity\Models;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModelCountriesRelation>
 *
 * @method ModelCountriesRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModelCountriesRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModelCountriesRelation[]    findAll()
 * @method ModelCountriesRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelCountriesRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModelCountriesRelation::class);
    }

    public function create(int $modelId, int $countryId)
    {
        $exist = $this->findOneBy(['modelId' => $modelId, 'countryId' => $countryId]);
        if ($exist) {
            return;
        }

        $model = $this->getEntityManager()->getRepository(Models::class)->find($modelId);
        $country = $this->getEntityManager()->getRepository(Country::class)->find($countryId);

        $entity = new ModelCountriesRelation();
        $entity->setModel($model);
        $entity->setCountry($country);
        $entity->setModelId($modelId);
        $entity->setCountryId($countryId);

        $this->save($entity, true);
    }

    public function createWorldWide(int $modelId)
    {
        $allCountries = $this->getEntityManager()->getRepository(Country::class)->findAll();

        /** @var Country $country */
        foreach ($allCountries as $country) {
            $countryId = $country->getId();
            $this->create($modelId, $countryId);
        }
    }

    public function save(ModelCountriesRelation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ModelCountriesRelation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ModelCountriesRelation[] Returns an array of ModelCountriesRelation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ModelCountriesRelation
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
