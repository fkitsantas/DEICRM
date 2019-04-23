<?php

namespace App\Repository;

use App\Entity\Opportunities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Opportunities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opportunities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opportunities[]    findAll()
 * @method Opportunities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpportunitiesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Opportunities::class);
    }

    // /**
    //  * @return Opportunities[] Returns an array of Opportunities objects
    //  */

    public function findByOpportunityName($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.OpportunityName LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByID($value): ?Opportunities
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findOneByOpportunityName($value): ?Opportunities
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.OpportunityName = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
