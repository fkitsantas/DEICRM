<?php

namespace App\Repository;

use App\Entity\CasesComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CasesComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CasesComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CasesComment[]    findAll()
 * @method CasesComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CasesCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CasesComment::class);
    }

    public function findByMessage($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Message LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function findOneByID($value): ?CasesComment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }



    public function findOneByMessage($value): ?CasesComment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.Message = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
