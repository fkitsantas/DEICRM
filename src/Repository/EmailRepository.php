<?php

namespace App\Repository;

use App\Entity\Email;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Email|null find($id, $lockMode = null, $lockVersion = null)
 * @method Email|null findOneBy(array $criteria, array $orderBy = null)
 * @method Email[]    findAll()
 * @method Email[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Email::class);
    }


    public function findOneByID($value): ?Email
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    // /**
    //  * @return Email[] Returns an array of Email objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Email
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
