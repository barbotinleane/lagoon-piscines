<?php

namespace App\Repository;

use App\Entity\FormationLibelles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationLibelles|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationLibelles|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationLibelles[]    findAll()
 * @method FormationLibelles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationLibellesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationLibelles::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FormationLibelles $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(FormationLibelles $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllToDisplayOnLagoonPiscines()
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.displayOnLagoonPiscines = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?FormationLibelles
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
