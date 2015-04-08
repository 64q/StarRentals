<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 06/04/2015
 * Time: 18:35
 */

namespace AppBundle\Service;


use AppBundle\Entity\Booking;
use AppBundle\Entity\Client;
use AppBundle\Entity\Vehicle;
use AppBundle\Repository\BookingRepository;
use AppBundle\Repository\VehicleRepository;
use Doctrine\ORM\EntityManager;

class UpgraderService
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Validate a booking
     *
     * @param Booking $booking
     * @return bool
     */
    public function validateUpgrade(Booking $booking)
    {
        /** @var VehicleRepository $vehicleRepository */
        $vehicleRepository = $this->em->getRepository('AppBundle:Vehicle');
        /** @var BookingRepository $bookingRepository */
        $bookingRepository = $this->em->getRepository('AppBundle:Booking');

        $isValid = true;

        /** @var Client $client */
        $client = $booking->getClient();
        /** @var Vehicle $vehicle */
        $vehicle = $booking->getVehicle();

        $totalVehicles = count($vehicleRepository->findAll());
        $rangeVehicles = count($vehicleRepository->findBy(array(
            'range' => $vehicle->getRange()
        )));

        // constraint 1: selected range should not excess 15% of the total of vehicles
        if (($rangeVehicles / $totalVehicles) > 0.15) {
            $isValid = false;
        }

        // constraint 2: upgraded range should contains 50% available vehicles
        $totalVehiclesAvailable = count($vehicleRepository->findAllAvailable(Vehicle::ELITE, $booking->getStartDate()));

        if (($totalVehiclesAvailable / $totalVehicles) < 0.5) {
            $isValid = false;
        }

        // constraint 3: client should have 2 bookings in the last 30 days
        $clientBookings = $bookingRepository->findLastBookings($client);

        if (count($clientBookings) < 2) {
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * Return the first available vehicle
     *
     * @param Booking $booking
     * @return mixed
     */
    public function upgradeVehicle(Booking $booking)
    {
        $availableVehicle = $this->em->getRepository('AppBundle:Vehicle')->findOneAvailable(Vehicle::ELITE, $booking->getStartDate());

        return $availableVehicle;
    }
}
