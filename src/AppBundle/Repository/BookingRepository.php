<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Client;
use Doctrine\ORM\EntityRepository;


class BookingRepository extends EntityRepository
{
    /**
     * Define our own findAll with appropriate joins to avoid lazy loading
     *
     * @return array
     */
    public function findAll()
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->addSelect('b, c, v')
            ->join('b.client', 'c')
            ->join('b.vehicle', 'v')
            ->addOrderBy('b.createdAt', 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Client $client
     * @return array
     */
    public function findLastBookings(Client $client)
    {
        $currentDate = new \DateTime();

        $interval = \DateInterval::createFromDateString('30 day');

        $olderDate = $currentDate->sub($interval);

        $qb = $this->createQueryBuilder('b');
        $qb->addSelect('b');
        $qb
            ->andWhere('b.client = :client')
            ->andWhere('b.createdAt >= :date')
            ->setParameters(array(
                'client' => $client,
                'date' => $olderDate
            ));

        return $qb->getQuery()->getResult();
    }
}