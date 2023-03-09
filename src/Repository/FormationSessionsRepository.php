<?php

namespace App\Repository;

use App\Entity\FormationLibelles;
use App\Entity\FormationSessions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationSessions|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationSessions|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationSessions[]    findAll()
 * @method FormationSessions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationSessionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationSessions::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FormationSessions $entity, bool $flush = true): void
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
    public function remove(FormationSessions $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return FormationSessions[] Returns an array of FormationSessions objects
     */
    public function findAllByFormation()
    {
        return $this->createQueryBuilder('f')
            ->where('f.dateEnd > CURRENT_DATE()')
            ->orderBy('f.formation')
            ->addOrderBy('f.formation', 'ASC')
            ->addOrderBy('f.dateStart', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return FormationSessions[] Returns an array of FormationSessions objects
     */
    public function findAllSessionsInChronologicalOrder(int $id)
    {
        return $this->createQueryBuilder('f')
            ->where('f.dateStart > CURRENT_DATE()')
            ->andWhere('f.formation = :id')
            ->orderBy('f.dateStart', 'ASC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllEvents(int $id): ?array
    {
        $dates = $this->createQueryBuilder('f')
            ->select('f.dateStart AS start', 'f.dateEnd AS end', 'f.registered', 'f.capacity')
            ->where('f.dateStart > CURRENT_DATE()')
            ->andWhere('f.formation = :id')
            ->orderBy('f.dateStart', 'ASC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
        $datesFormated = [];

        foreach($dates as $date) {
            $description = "Remplissage : ".$date["registered"]."/".$date["capacity"]." pers.";
            $title = $date["registered"] < $date["capacity"] ? "Reste ".$date["capacity"]-$date["registered"]." places" : "Complet !";
            $color = $date["registered"] < $date["capacity"] ? "green" : "red";
            $datesFormated[] = [
                "start" => $date["start"]->format('Y-m-d'),
                "end" => $date["end"]->modify('+1 day')->format('Y-m-d'),
                "title" => $title,
                "description" => $description,
                "color" => $color,
            ];
        }

        return $datesFormated;
    }
}
