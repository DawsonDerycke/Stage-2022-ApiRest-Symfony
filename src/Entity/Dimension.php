<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DimensionRepository::class)
 */
class Dimension
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Dimension;

    /**
     * @ORM\OneToOne(targetEntity=Sku::class, inversedBy="dimension", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true, onDelete="CASCADE")
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDimension(): ?string
    {
        return $this->Dimension;
    }

    public function setDimension(string $Dimension): self
    {
        $this->Dimension = $Dimension;

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
