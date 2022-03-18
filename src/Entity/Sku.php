<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SkuRepository")
 */
class Sku
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $Sku;

    /**
     * @ORM\OneToOne(targetEntity=Dimension::class, mappedBy="sku", cascade={"persist", "remove"})
     */
    private $dimension;

    /**
     * @ORM\OneToOne(targetEntity=Price::class, mappedBy="sku", cascade={"persist", "remove"})
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity=Stock::class, mappedBy="sku", cascade={"persist", "remove"})
     */
    private $stock;

    /**
     * @ORM\OneToOne(targetEntity=Weight::class, mappedBy="sku", cascade={"persist", "remove"})
     */
    private $weight;

    /**
     * @ORM\OneToOne(targetEntity=ProductManager::class, mappedBy="sku", cascade={"persist", "remove"})
     */
    private $productManager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSku(): ?string
    {
        return $this->Sku;
    }

    public function setSku(string $Sku): self
    {
        $this->Sku = $Sku;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => 'Sku',
        ]));
    }

    public function classMethodsGet(): array
    {
        $class = get_class_methods(new Sku());
    
        foreach ($class as $name) {
            if (preg_match('/^get/', $name)) {
                $nameEntity = preg_replace('/^get/', '', $name);
    
                if (class_exists("App\Entity\\$nameEntity")) {
                    $array[] = array($name);
                }
            }
        }
        return $array;
    }
    
    public function classMethodsSet(): array
    {
        $class = get_class_methods(new Sku());
    
        foreach ($class as $name) {
            if (preg_match('/^set/', $name)) {
                $nameEntity = preg_replace('/^set/', '', $name);
    
                if (class_exists("App\Entity\\$nameEntity")) {
                    $array[] = array($name);
                }
            }
        }
        return $array;
    }
    
    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    public function setDimension(Dimension $dimension): self
    {
        // set the owning side of the relation if necessary
        if ($dimension->getSku() !== $this) {
            $dimension->setSku($this);
        }

        $this->dimension = $dimension;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        // set the owning side of the relation if necessary
        if ($price->getSku() !== $this) {
            $price->setSku($this);
        }

        $this->price = $price;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): self
    {
        // set the owning side of the relation if necessary
        if ($stock->getSku() !== $this) {
            $stock->setSku($this);
        }

        $this->stock = $stock;

        return $this;
    }

    public function getWeight(): ?Weight
    {
        return $this->weight;
    }

    public function setWeight(Weight $weight): self
    {
        // set the owning side of the relation if necessary
        if ($weight->getSku() !== $this) {
            $weight->setSku($this);
        }

        $this->weight = $weight;

        return $this;
    }

    
    public function getProductManager(): ?ProductManager
    {
        return $this->productManager;
    }

    public function setProductManager(ProductManager $productManager): self
    {
        // set the owning side of the relation if necessary
        if ($productManager->getSku() !== $this) {
            $productManager->setSku($this);
        }

        $this->productManager = $productManager;

        return $this;
    }
    
}
