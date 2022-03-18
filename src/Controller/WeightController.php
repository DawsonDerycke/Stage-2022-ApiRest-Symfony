<?php

namespace App\Controller;

use App\Repository\WeightRepository;
use App\Repository\SkuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WeightSiteController
 * @package App\Controller
 *
 * @Route(path="/weight")
 */

class WeightController extends AbstractController
{
    private $weightRepository;
    private $skuRepository;

    public function __construct(WeightRepository $weightRepository, SkuRepository $skuRepository)
    {
        $this->weightRepository = $weightRepository;
        $this->skuRepository = $skuRepository;
    }

    /**
     * @Route("/{sku}", name="get_one_weight", methods={"GET"})
     */
    public function getOneWeight($sku): JsonResponse
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $id = $resultSku->getId();
        $weight = $this->weightRepository->findOneBy(['sku' => $id]);
        
        if (!$weight) {
            throw $this->createNotFoundException(
                'No weight found for sku '.$sku
            );
        }
        $data = [
            'Sku' => $weight->getSku()->getSku(),
            'Weight' => $weight->getWeight(),
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route(name="get_all_weights", methods={"GET"})
     */
    public function getAllWeights(): JsonResponse
    {
        $weights = $this->weightRepository->findBy(
            array(),
            array('Weight' => 'ASC')
        );
        $data = [];

        foreach ($weights as $weight) {
            $data[] = [
                'Sku' => $weight->getSku()->getSku(),
                'Weight' => $weight->getWeight(),
            ];
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
