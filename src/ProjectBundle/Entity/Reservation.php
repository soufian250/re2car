<?php

namespace ProjectBundle\Entity;

/**
 * Reservation
 */
class Reservation
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Reservation
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Reservation
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    /**
     * @var integer
     */
    private $daysNumber;


    /**
     * Set daysNumber
     *
     * @param integer $daysNumber
     *
     * @return Reservation
     */
    public function setDaysNumber($daysNumber)
    {
        $this->daysNumber = $daysNumber;

        return $this;
    }

    /**
     * Get daysNumber
     *
     * @return integer
     */
    public function getDaysNumber()
    {
        return $this->daysNumber;
    }
    /**
     * @var \DateTime
     */
    private $startTime;

    /**
     * @var \DateTime
     */
    private $endTime;


    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return Reservation
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return Reservation
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }
    /**
     * @var \ProjectBundle\Entity\Client
     */
    private $client;


    /**
     * Set client
     *
     * @param \ProjectBundle\Entity\Client $client
     *
     * @return Reservation
     */
    public function setClient(\ProjectBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \ProjectBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
    /**
     * @var \ProjectBundle\Entity\Car
     */
    private $car;


    /**
     * Set car
     *
     * @param \ProjectBundle\Entity\Car $car
     *
     * @return Reservation
     */
    public function setCar(\ProjectBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \ProjectBundle\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }

    public function getThisClass() {
        return Reservation::class;
    }
    /**
     * @var bool
     */
    private $statusReservation = false;


    /**
     * Set statusReservation.
     *
     * @param bool $statusReservation
     *
     * @return Reservation
     */
    public function setStatusReservation($statusReservation)
    {
        $this->statusReservation = $statusReservation;

        return $this;
    }

    /**
     * Get statusReservation.
     *
     * @return bool
     */
    public function getStatusReservation()
    {
        return $this->statusReservation;
    }
    /**
     * @var float
     */
    private $amountTotal = 0;


    /**
     * Set amountTotal.
     *
     * @param float $amountTotal
     *
     * @return Reservation
     */
    public function setAmountTotal($amountTotal)
    {
        $this->amountTotal = $amountTotal;

        return $this;
    }

    /**
     * Get amountTotal.
     *
     * @return float
     */
    public function getAmountTotal()
    {
        return $this->amountTotal;
    }
    /**
     * @var bool
     */
    private $cautionStatus = false;


    /**
     * Set cautionStatus.
     *
     * @param bool $cautionStatus
     *
     * @return Reservation
     */
    public function setCautionStatus($cautionStatus)
    {
        $this->cautionStatus = $cautionStatus;

        return $this;
    }

    /**
     * Get cautionStatus.
     *
     * @return bool
     */
    public function getCautionStatus()
    {
        return $this->cautionStatus;
    }
}
