<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeightRepository::class)
 */
class Weight
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
    private $Weight;

    /**
     * @ORM\OneToOne(targetEntity=Sku::class, inversedBy="weight", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true, onDelete="CASCADE")
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?float
    {
        return $this->Weight;
    }

    public function setWeight(float $Weight): self
    {
        $this->Weight = $Weight;

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
