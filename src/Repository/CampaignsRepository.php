<?php

namespace App\Repository;

use App\Entity\Campaigns;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Campaigns|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campaigns|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campaigns[]    findAll()
 * @method Campaigns[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Campaigns::class);
    }

    // /**
    //  * @return Campaigns[] Returns an array of Campaigns objects
    //  */

    public function findByName($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Name LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByID($value): ?Campaigns
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function findOneByName($value): ?Campaigns
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
