<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Stock;

    /**
     * @ORM\OneToOne(targetEntity=Sku::class, inversedBy="stock", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true, onDelete="CASCADE")
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;

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
