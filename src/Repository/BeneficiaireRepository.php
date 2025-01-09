<?php

namespace App\Repository;

use App\Entity\Beneficiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Beneficiaire>
 */
class BeneficiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beneficiaire::class);
    }

    public function findAllByCategorie(string $statut)
    {
        return $this->createQueryBuilder('b')
            ->addSelect('u')
            ->join('b.user', 'u')
            ->where('u.statut = :statut')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->getQuery()->getResult()
            ;
    }

    public function findPostulant(string $statut = null)
    {
        return $this->querySelect()
            ->where('b.statut IS NULL OR b.statut = :statut')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->getQuery()->getResult()
            ;
    }

    public function findByStatutAndClasse(string $statut = null, string $statut2 = null, string $classe)
    {
        return $this->querySelect()
            ->where('b.statut = :statut OR b.statut = :statut2')
            ->andWhere('b.classe = :classe')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->setParameter('statut2', $statut2)
            ->setParameter('classe', $classe)
            ->getQuery()->getResult()
            ;
    }

    public function findByOneStatutAndClasse(string $statut = null, string $classe)
    {
        return $this->querySelect()
            ->where('b.statut = :statut')
            ->andWhere('b.classe = :classe')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->setParameter('classe', $classe)
            ->getQuery()->getResult()
            ;
    }

    public function findByOneStatutClasseAndSexe(string $statut = null, string $classe, string $sexe)
    {
        return $this->querySelect()
            ->where('b.statut = :statut')
            ->andWhere('b.classe = :classe')
            ->andWhere('b.sexe = :sexe')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->setParameter('classe', $classe)
            ->setParameter('sexe', $sexe)
            ->getQuery()->getResult()
            ;
    }

    public function findByStatut(string $statut = null)
    {
        return $this->querySelect()
            ->where('b.statut = :statut')
            ->orderBy('b.nom', 'ASC')
            ->addOrderBy('b.prenom', 'ASC')
            ->setParameter('statut', $statut)
            ->getQuery()->getResult()
            ;
    }

    public function querySelect(): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->addSelect('d')
            ->addSelect('s')
            ->addSelect('n')
            ->addSelect('f')
            ->addSelect('u')
            ->leftJoin('b.diplome', 'd')
            ->leftJoin('b.specialite', 's')
            ->leftJoin('b.niveauEtude', 'n')
            ->leftJoin('b.natureFormation', 'f')
            ->leftJoin('b.user', 'u')
            ;
    }

    //    /**
    //     * @return Beneficiaire[] Returns an array of Beneficiaire objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Beneficiaire
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

}
