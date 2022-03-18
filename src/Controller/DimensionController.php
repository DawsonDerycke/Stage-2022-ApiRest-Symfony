<?php

namespace App\Controller;

use App\Repository\DimensionRepository;
use App\Repository\SkuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DimensionSiteController
 * @package App\Controller
 *
 * @Route(path="/dimension")
 */

class DimensionController extends AbstractController
{
    private $dimensionRepository;
    private $skuRepository;

    public function __construct(DimensionRepository $dimensionRepository, SkuRepository $skuRepository)
    {
        $this->dimensionRepository = $dimensionRepository;
        $this->skuRepository = $skuRepository;
    }

    /**
     * @Route("/{sku}", name="get_one_dimension", methods={"GET"})
     */
    public function getOneDimension($sku): JsonResponse
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $id = $resultSku->getId();
        $dimension = $this->dimensionRepository->findOneBy(['sku' => $id]);
        
        if (!$dimension) {
            throw $this->createNotFoundException(
                'No dimension found for sku '.$sku
            );
        }
        $data = [
            'Sku' => $dimension->getSku()->getSku(),
            'Dimension' => $dimension->getDimension(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route(name="get_all_dimensions", methods={"GET"})
     */
    public function getAllDimensions(): JsonResponse
    {
        $dimensions = $this->dimensionRepository->findBy(
            array(),
            array('Dimension' => 'ASC')
        );
        $data = [];

        foreach ($dimensions as $dimension) {
            $data[] = [
                'Sku' => $dimension->getSku()->getSku(),
                'Dimension' => $dimension->getDimension(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}