<?php

namespace App\Repository;

use App\Entity\Entrepreneuriat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entrepreneuriat>
 */
class EntrepreunariatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrepreneuriat::class);
    }

    public function findAllEntreprises()
    {
        return $this->querySelect()->getquery()->getResult();
    }
    public function findAllEntreprisesByStatut(string $finance = null)
    {
        return $this->querySelect()->andWhere('e.statut = :statut')->setParameter('statut', $finance)->getquery()->getResult();
    }
    public function findByStatut(?string $finance = null)
    {
        $query = $this->querySelect();

        if ($finance) {
            $query->andWhere('e.statut = :statut')->setParameter('statut', $finance);
        }else{
            $query->where('e.statut IS NULL');
        }
        return $query->getQuery()->getResult();
    }

    public function findTotalFinance()
    {
        return $this->querySelect()->select('SUM(e.montantFinance) as total')->getQuery()->getSingleScalarResult();
    }

    public function querySelect()
    {
        return $this->createQueryBuilder('e')
            ->addSelect('b')
            ->leftJoin('e.beneficiaire', 'b')
            ;
    }

    //    /**
    //     * @return Entrepreneuriat[] Returns an array of Entrepreneuriat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Entrepreneuriat
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
