<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductManagerRepository::class)
 */
class ProductManager
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
    private $ProductManager;

    /**
     * @ORM\OneToOne(targetEntity=Sku::class, inversedBy="productManager", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true, onDelete="CASCADE")
     */
    private $sku;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductManager(): ?string
    {
        return $this->ProductManager;
    }

    public function setProductManager(string $ProductManager): self
    {
        $this->ProductManager = $ProductManager;

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
