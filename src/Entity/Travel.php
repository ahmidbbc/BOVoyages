<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TravelRepository")
 */
class Travel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $destination;

    /**
     * @ORM\Column(type="text")
     */
    private $details;

    /**
     * @ORM\Column(type="date")
     */
    private $fromDate;

    /**
     * @ORM\Column(type="date")
     */
    private $toDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxGuests;

    /**
     * @ORM\Column(type="float")
     */
    private $retailPrice;

    /**
     * @ORM\Column(type="smallint")
     */
    private $discountRate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="travels", cascade={"persist"})
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $clientCreditCard;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(int $maxGuests): self
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    public function getRetailPrice(): ?float
    {
        return $this->retailPrice;
    }

    public function setRetailPrice(float $retailPrice): self
    {
        $this->retailPrice = $retailPrice;

        return $this;
    }

    public function getDiscountRate(): ?int
    {
        return $this->discountRate;
    }

    public function setDiscountRate(int $discountRate): self
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getClientCreditCard(): ?string
    {
        return $this->clientCreditCard;
    }

    public function setClientCreditCard(?string $clientCreditCard): self
    {
        $this->clientCreditCard = $clientCreditCard;

        return $this;
    }
}
