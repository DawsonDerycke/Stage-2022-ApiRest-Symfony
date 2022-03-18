<?php

namespace App\Repository;

use App\Entity\ProductManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductManager[]    findAll()
 * @method ProductManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductManager::class);
    }

    // /**
    //  * @return ProductManager[] Returns an array of ProductManager objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductManager
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
