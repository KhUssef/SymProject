<?php

namespace App\Repository;

use App\Entity\Experience;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Experience>
 */
class ExperienceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experience::class);
    }

    //    /**
    //     * @return Experience[] Returns an array of Experience objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Experience
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
    //     * @return Experience[] Returns an array of Experience objects
    //     */
    public function findexps(): array
    {
        return $this->createQueryBuilder('e')
            ->groupBy('e.name')->getQuery()->getResult();
    }
    public function findByExpression($value): array
    {
        $query = $this->createQueryBuilder('e')
            ->andWhere('e.name = :name')
            ->setParameter('name', $value[0]);
        if (strpos($value[1], 'and')) {
            $query->andWhere( "(e.years " . substr($value[1], 0, strpos($value[1], 'and') + 3) . " e.years " . substr($value[1], strpos($value[1], 'and') + 3, strlen($value[1])) . ')');
        } else if (strpos($value[1], 'or')) {
            $query->andWhere('(e.years ' . substr($value[1], 0, strpos($value[1], 'or') + 2) . ' e.years ' . substr($value[1], strpos($value[1], 'or') + 3, strlen($value[1])) . ')');
        } else {
            $query->andWhere('e.years ' . ' ' . $value[1]);
        }
        return $query->getQuery()->getResult();
    }
}
