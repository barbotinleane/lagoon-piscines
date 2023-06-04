<?php

namespace App\Repository;

use App\Entity\FaqCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FaqCategory>
 *
 * @method FaqCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqCategory[]    findAll()
 * @method FaqCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaqCategory::class);
    }

    public function save(FaqCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FaqCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function nameExists(string $name) {
        $categories = $this->createQueryBuilder('f')
            ->getQuery()
            ->getResult()
        ;

        foreach ($categories as $category) {
            if($category->getName() === $name) {
                return true;
            }
        }

        return false;
    }

//    /**
//     * @return FaqCategory[] Returns an array of FaqCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FaqCategory
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
