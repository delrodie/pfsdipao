<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function findByBeneficiaire($benficiaire)
    {
        return $this->querySelect()
            ->where('f.beneficiaire = :benficiaire')
            ->setParameter('benficiaire', $benficiaire)
            ->getQuery()
            ->getResult()
            ;
    }

    public function querySelect()
    {
        return $this->createQueryBuilder('f')
            ->addSelect('b')
            ->addSelect('s')
            ->addSelect('d')
            ->leftJoin('f.beneficiaire', 'b')
            ->leftJoin('f.specialisation', 's')
            ->leftJoin('f.diplome', 'd')
            ;
    }

    //    /**
    //     * @return Formation[] Returns an array of Formation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Formation
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
