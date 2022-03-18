<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceRepository::class)
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\OneToOne(targetEntity=Sku::class, inversedBy="price", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true, onDelete="CASCADE")
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getSku(): ?Sku
    {
        return $this->sku;
    }

    public function setSku(Sku $sku): self
    {
        $this->sku = $sku;

        return $this;
    }
}
