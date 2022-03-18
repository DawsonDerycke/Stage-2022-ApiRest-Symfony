<?php

namespace App\Controller;

use App\Repository\ProductManagerRepository;
use App\Repository\SkuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductManagerSiteController
 * @package App\Controller
 *
 * @Route(path="/productManager")
 */

class ProductManagerController extends AbstractController
{
    private $productManagerRepository;
    private $skuRepository;

    public function __construct(ProductManagerRepository $productManagerRepository, SkuRepository $skuRepository)
    {
        $this->productManagerRepository = $productManagerRepository;
        $this->skuRepository = $skuRepository;
    }

    /**
     * @Route("/{sku}", name="get_one_productManager", methods={"GET"})
     */
    public function getOneProductManager($sku): JsonResponse
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $id = $resultSku->getId();
        $productManager = $this->productManagerRepository->findOneBy(['sku' => $id]);
        
        if (!$productManager) {
            throw $this->createNotFoundException(
                'No product manager found for sku '.$sku
            );
        }
        $data = [
            'Sku' => $productManager->getSku()->getSku(),
            'ProductManager' => $productManager->getProductManager(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route(name="get_all_productManagers", methods={"GET"})
     */
    public function getAllProductManager(): JsonResponse
    {
        $productManagers = $this->productManagerRepository->findBy(
            array(),
            array('ProductManager' => 'ASC')
        );
        $data = [];

        foreach ($productManagers as $productManager) {
            $data[] = [
                'Sku' => $productManager->getSku()->getSku(),
                'ProductManager' => $productManager->getProductManager(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}