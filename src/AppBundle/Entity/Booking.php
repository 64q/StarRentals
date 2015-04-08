<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints\ConstraintUpgraded;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookingRepository")
 * @ORM\Table(name="booking")
 *
 * @ConstraintUpgraded()
 */
class Booking
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client")
     * @Assert\NotNull()
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", inversedBy="bookings")
     * @Assert\NotNull()
     */
    protected $vehicle;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $endDate;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $upgraded = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();

        $this->startDate = new \DateTime();
        $this->endDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpgraded()
    {
        return $this->upgraded;
    }

    /**
     * @param mixed $upgraded
     */
    public function setUpgraded($upgraded)
    {
        $this->upgraded = $upgraded;
    }

    public static function listHumanUpgraded()
    {
        return array(
            true => 'Upgraded',
            false => 'Not upgraded'
        );
    }

    public function humanUpgraded()
    {
        return Booking::listHumanUpgraded()[$this->upgraded];
    }
}
