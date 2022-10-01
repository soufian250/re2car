<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuration
 *
 */
class Configuration
{

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }



    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $maintenancePeriod;

    /**
     * @var int
     */
    private $maintenanceMileage;

    /**
     * @var bool
     */
    private $mileage;

    /**
     * @var bool
     */
    private $periodBool;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \ProjectBundle\Entity\Car
     */
    private $car;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set maintenancePeriod.
     *
     * @param string $maintenancePeriod
     *
     * @return Configuration
     */
    public function setMaintenancePeriod($maintenancePeriod)
    {
        $this->maintenancePeriod = $maintenancePeriod;

        return $this;
    }

    /**
     * Get maintenancePeriod.
     *
     * @return string
     */
    public function getMaintenancePeriod()
    {
        return $this->maintenancePeriod;
    }

    /**
     * Set maintenanceMileage.
     *
     * @param int $maintenanceMileage
     *
     * @return Configuration
     */
    public function setMaintenanceMileage($maintenanceMileage)
    {
        $this->maintenanceMileage = $maintenanceMileage;

        return $this;
    }

    /**
     * Get maintenanceMileage.
     *
     * @return int
     */
    public function getMaintenanceMileage()
    {
        return $this->maintenanceMileage;
    }

    /**
     * Set mileage.
     *
     * @param bool $mileage
     *
     * @return Configuration
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage.
     *
     * @return bool
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set periodBool.
     *
     * @param bool $periodBool
     *
     * @return Configuration
     */
    public function setPeriodBool($periodBool)
    {
        $this->periodBool = $periodBool;

        return $this;
    }

    /**
     * Get periodBool.
     *
     * @return bool
     */
    public function getPeriodBool()
    {
        return $this->periodBool;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Configuration
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Configuration
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set car.
     *
     * @param \ProjectBundle\Entity\Car|null $car
     *
     * @return Configuration
     */
    public function setCar(\ProjectBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car.
     *
     * @return \ProjectBundle\Entity\Car|null
     */
    public function getCar()
    {
        return $this->car;
    }
}
