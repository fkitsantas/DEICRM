<?php

namespace App\Repository;

use App\Entity\Interaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Interaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interaction[]    findAll()
 * @method Interaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteractionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Interaction::class);
    }


    public function findByID($value, $type): ?Interaction
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.WhoTo = :val')
            ->andWhere('c.Type = :valtype')
            ->setParameter('val', $value)
            ->setParameter('valtype', $type)
            ->getQuery()
           ->getResult();
        ;
    }
}
