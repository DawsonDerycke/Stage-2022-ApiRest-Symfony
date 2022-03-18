<?php

namespace App\Controller;

use App\Repository\StockRepository;
use App\Repository\SkuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class StockSiteController
 * @package App\Controller
 *
 * @Route(path="/stock")
 */

class StockController extends AbstractController
{
    private $stockRepository;
    private $skuRepository;

    public function __construct(StockRepository $stockRepository, SkuRepository $skuRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->skuRepository = $skuRepository;
    }

    /**
     * @Route("/{sku}", name="get_one_stock", methods={"GET"})
     */
    public function getOneStock($sku): JsonResponse
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $id = $resultSku->getId();
        $stock = $this->stockRepository->findOneBy(['sku' => $id]);
        
        if (!$stock) {
            throw $this->createNotFoundException(
                'No stock found for sku '.$sku
            );
        }
        $data = [
            'Sku' => $stock->getSku()->getSku(),
            'Stock' => $stock->getStock(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route(name="get_all_stocks", methods={"GET"})
     */
    public function getAllStocks(): JsonResponse
    {
        $stocks = $this->stockRepository->findBy(
            array(),
            array('Stock' => 'ASC')
        );
        $data = [];

        foreach ($stocks as $stock) {
            $data[] = [
                'Sku' => $stock->getSku()->getSku(),
                'Stock' => $stock->getStock(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
