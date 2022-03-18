<?php

namespace App\Repository;

use App\Entity\Sku;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Sku|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sku|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sku[]    findAll()
 * @method Sku[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkuRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Sku::class);
        $this->manager = $manager;
    }

    public function saveSku($newSku)
    {
        $this->manager->persist($newSku);
        $this->manager->flush();
    }

    public function updateSku()
    {
        $this->manager->flush();
    }

    public function removeSku(Sku $sku)
    {
        $this->manager->remove($sku);
        $this->manager->flush();
    }

    // /**
    //  * @return Sku[] Returns an array of Sku objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sku
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
