<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;


class VehicleRepository extends EntityRepository
{
    /**
     * @param $range integer vehicle range
     * @param $date \DateTime start date
     * @return array
     */
    public function findAllAvailable($range, $date)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->addSelect('v');
        $qb
            ->leftJoin('v.bookings', 'b')
            ->andWhere('v.range = :range')
            ->andWhere('b.startDate < :date OR b.startDate IS NULL')
            ->setParameters(array(
                'range' => $range,
                'date' => $date
            ));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $range integer vehicle range
     * @param $date \DateTime start date
     * @return array
     */
    public function findOneAvailable($range, $date)
    {
        $qb = $this->createQueryBuilder('v');
        $qb->addSelect('v');
        $qb
            ->leftJoin('v.bookings', 'b')
            ->andWhere('v.range = :range')
            ->andWhere('b.startDate < :date OR b.startDate IS NULL')
            ->setParameters(array(
                'range' => $range,
                'date' => $date
            ))
            ->setMaxResults(1);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch(NoResultException $ex) {
            return null;
        }
    }
}