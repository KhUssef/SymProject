<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

        /**
         * @return Job[] Returns an array of Job objects
         */
        public function findByMaster($value): array
        {
            return $this->createQueryBuilder('j')
                ->andWhere('j.master = :val')
                ->setParameter('val', $value)
                ->orderBy('j.id', 'ASC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Job
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * @return Job[] Returns an array of Job objects
     */
    public function findByFilters($value, ExperienceRepository $experienceRepository): array
    {
        $query = $this->createQueryBuilder('e');
        $ids = array();
        foreach ($value as $filter) {
            $list = explode(":", $filter);
            if (strtolower(trim($list[0])) == 'description') {
                $query->andWhere('e.description LIKE :description')
                    ->setParameter('description', '%' . trim($list[1]) . '%');
            } else if (strtolower(trim($list[0])) == 'price') {
                if (strpos($list[1], 'and')) {
                    $query->andWhere("(e.price " . substr($list[1], 0, strpos($list[1], 'and')) . ' and ' . " e.price " . substr($list[1], strpos($list[1], 'and') + 3, strlen($list[1])) . ')');
                } else if (strpos($list[1], 'or')) {
                    $query->andWhere("(e.price " . substr($list[1], 0, strpos($list[1], 'or')) . ' or ' . " e.price " . substr($list[1], strpos($list[1], 'or') + 2, strlen($list[1])) . ')');
                } else {
                    $query->andWhere('e.price ' . $list[1]);
                }
            } else {
                $ids = array_merge($ids, $experienceRepository->findByExpression($list));
            }
        }
        if (count($ids) > 0) {
            $query->innerJoin('e.experience', 'ex')->andWhere('ex.id IN (:ids)')
                ->setParameter('ids', $ids);
        }
        return $query->getQuery()->getResult();
    }
}
