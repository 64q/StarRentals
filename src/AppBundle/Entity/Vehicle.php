<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints\ConstraintColor;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleRepository")
 * @ORM\Table(name="vehicle")
 *
 * @ConstraintColor()
 */
class Vehicle
{
    /**
     * Basic range
     */
    const BASIC = 1;

    /**
     * Elite range
     */
    const ELITE = 2;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="vrange", type="smallint")
     * @Assert\NotBlank()
     */
    protected $range;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $color;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Booking", mappedBy="vehicle")
     */
    protected $bookings;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param mixed $range
     */
    public function setRange($range)
    {
        $this->range = $range;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getBookings()
    {
        return $this->bookings;
    }

    /**
     * @param mixed $bookings
     */
    public function setBookings($bookings)
    {
        $this->bookings = $bookings;
    }

    public static function listHumanRanges()
    {
        return array(
            Vehicle::BASIC => 'XWing',
            Vehicle::ELITE => 'TieFighter'
        );
    }

    public static function listHumanAvailabilities()
    {
        return array(
            true => 'Available',
            false => 'Unavailable'
        );
    }

    public function humanRange()
    {
        return Vehicle::listHumanRanges()[$this->range];
    }

    public function __toString()
    {
        return $this->humanRange() . ' ' . $this->getName();
    }
}