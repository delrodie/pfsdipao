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
    public function findByRemboursement(?string $remboursement = null, string $finance = null)
    {
        $query = $this->querySelect();

        if ($remboursement) {
            $query
                ->andWhere('e.statutRemboursement = :statut')
                ->andWhere('e.statut = :finance')
                ->setParameter('statut', $remboursement)
                ->setParameter('finance', $finance);
        }else{
            $query->where('e.statutRemboursement IS NULL')
            ->andWhere('e.statut = :finance')
            ->setParameter('finance', $finance);
        }
        return $query->getQuery()->getResult();
    }

    public function findByStatutAndSexe(string $finance = null, string $sexe = null)
    {
        $query = $this->querySelect();

        if ($finance) {
            $query->andWhere('e.statut = :statut')
                ->andWhere('b.sexe = :sexe')
                ->setParameter('statut', $finance)
                ->setParameter('sexe', $sexe);
        }else{
            $query->where('e.statut IS NULL')
            ->andWhere('b.sexe = :sexe')
            ->setParameter('sexe', $sexe);
        }
        return $query->getQuery()->getResult();
    }
    public function findByRemboursementAndSexe(string $remboursement = null, string $sexe = null, string $finance = null)
    {
        $query = $this->querySelect();

        if ($remboursement) {
            $query->andWhere('e.statutRemboursement = :statut')
                ->andWhere('b.sexe = :sexe')
                ->setParameter('statut', $remboursement)
                ->setParameter('sexe', $sexe);
        }else{
            $query->where('e.statutRemboursement IS NULL')
                ->andWhere('b.sexe = :sexe')
                ->andWhere('b.statut = :statut')
                ->setParameter('sexe', $sexe)
                ->setParameter('statut', $finance);
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
