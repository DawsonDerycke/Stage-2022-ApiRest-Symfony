<?php

namespace App\Controller;

use App\Repository\PriceRepository;
use App\Repository\SkuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PriceSiteController
 * @package App\Controller
 *
 * @Route(path="/price")
 */

class PriceController extends AbstractController
{
    private $priceRepository;
    private $skuRepository;

    public function __construct(PriceRepository $priceRepository, SkuRepository $skuRepository)
    {
        $this->priceRepository = $priceRepository;
        $this->skuRepository = $skuRepository;
    }

    /**
     * @Route("/{sku}", name="get_one_price", methods={"GET"})
     */
    public function getOnePrice($sku): JsonResponse
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $id = $resultSku->getId();
        $price = $this->priceRepository->findOneBy(['sku' => $id]);
        
        if (!$price) {
            throw $this->createNotFoundException(
                'No price found for sku '.$sku
            );
        }
        $data = [
            'Sku' => $price->getSku()->getSku(),
            'Price' => $price->getPrice(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route(name="get_all_prices", methods={"GET"})
     */
    public function getAllPrices(): JsonResponse
    {
        $prices = $this->priceRepository->findBy(
            array(),
            array('Price' => 'ASC')
        );
        $data = [];
        
        foreach ($prices as $price) {
            $data[] = [
                'Sku' => $price->getSku()->getSku(),
                'Price' => $price->getPrice(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
