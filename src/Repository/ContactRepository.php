<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    // /**
    //  * @return Contact[] Returns an array of Contact objects
    //  */

    public function findByLastName($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.LastName LIKE :val OR c.FirstName LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByName($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.LastName LIKE :val OR c.FirstName LIKE :val OR c.EmailAddress LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneByID($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByNotID($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id != :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByLastName($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.LastName = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
