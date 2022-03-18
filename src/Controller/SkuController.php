<?php

namespace App\Controller;

use App\Entity\Sku;
use App\Repository\SkuRepository;
use App\Form\SkuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkuSiteController
 * @package App\Controller
 *
 * @Route(path="/sku")
 */

class SkuController extends AbstractController
{
    private $skuRepository;
    
    public function __construct(SkuRepository $skuRepository)
    {
        $this->skuRepository = $skuRepository;
    }
    
    #region add_sku
    /**
    * @Route("/add", name="add_sku", methods={"GET", "POST"})
    */
    public function add(Request $request): Response
    { 
        $newSku = new Sku();
        // For API
        if($request->getContentType() === "json") {
            $data = json_decode($request->getContent(), true);

            foreach($newSku->classMethodsSet() as $array) {
                foreach($array as $setProperty) {
                    $property = preg_replace('/^set/', '', $setProperty);
                    $getProperty = preg_replace('/^set/', 'get', $setProperty);
                    $class = "App\Entity\\$property";
                    $class = new $class();

                    // Condition of properties
                    if (preg_match('/setSku/', $setProperty)) {
                        $skuValue = $data[$property];
                        
                        if (empty($skuValue) || $skuValue <= 0) {
                            throw new NotFoundHttpException('Sku is required !');
                        }
                        $newSku->$setProperty($skuValue);
                        continue;
                    }
                    if (!isset($data[$property])) {
                        continue;
                    }
                    $value = $class->$setProperty($data[$property]);
                    switch (gettype($value->$getProperty())) {
                        case 'double':
                            if ($value->$getProperty() <= 0) {
                                throw new NotFoundHttpException('Error '.$property.' parameters !');
                            }
                            break;
                        case 'integer':
                            if ($value->$getProperty() < 0) {
                                throw new NotFoundHttpException('Error '.$property.' parameters !');
                            }
                            break;
                    }
                    $newSku->$setProperty($value);
                }
            }
            $this->skuRepository->saveSku($newSku);
        
            return new JsonResponse(['Status' => 'Sku added !'], Response::HTTP_CREATED);
        }
        // For HTML
        $form = $this->createForm(SkuType::class, $newSku);
        
        try{
            $form->handleRequest($request);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" 
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 
                        0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 
                        5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                    />
                </svg>
                <?php echo $message ?>
            </div>
            <?php
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Condition of properties
            foreach($data->classMethodsGet() as $array) {
                foreach($array as $getProperty) {
                    $property = preg_replace('/^get/', '', $getProperty);

                    if (preg_match('/getSku/', $getProperty)) {
                        $skuValue = $data->$getProperty();
                        
                        if (empty($skuValue) || $skuValue <= 0) {
                            throw new NotFoundHttpException('Sku is required !');
                        }
                        continue;
                    }
                    $objvalue = $data->$getProperty();
                    $objvalue === NULL ? true : $value = $objvalue->$getProperty();

                    if (isset($value)) {
                        switch (gettype($value)) {
                            case 'double':
                                if ($value <= 0) {
                                    throw new NotFoundHttpException('Error '.$property.' parameters !');
                                }
                                break;
                            case 'integer':
                                if ($value < 0) {
                                    throw new NotFoundHttpException('Error '.$property.' parameters !');
                                }
                                break;
                        }
                    }
                }
            }
            $this->skuRepository->saveSku($newSku);
            
            return $this->redirectToRoute('get_all_sku', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('add.html.twig', [
            'Sku' => $newSku,
            'form' => $form,
        ]);
    }
    #endregion

    #region get_one_sku
    /**
     * @Route("/{sku}", name="get_one_sku", methods={"GET"})
     */
    public function getOneSku($sku, Request $request): Response
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);

        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $data = [];
        // Get all properties
        foreach($resultSku->classMethodsGet() as $array) {
            foreach($array as $getProperty) {
                if (preg_match('/getSku/', $getProperty)) {
                    $data = array("Sku" => $resultSku->getSku());
                    continue;
                }
                $property = preg_replace('/^get/', '', $getProperty);
                
                $objvalue = $resultSku->$getProperty();
                $objvalue === NULL ? $value = 'Empty' : $value = $objvalue->$getProperty();
                
                $data[$property] = $value;
            }
        }
        if($request->getContentType() === "json") {
            return new JsonResponse($data, Response::HTTP_OK);
        }
        return $this->render('oneSku.html.twig', [
            'data' => $data,
        ]);
    }
    #endregion

    #region get_all_sku
    /**
     * @Route(name="get_all_sku", methods={"GET"})
     */
    public function getAllSkus(Request $request): Response
    {
        try{
            $skus = $this->skuRepository->findAll();
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            echo "<script type='text/javascript'>alert('$message')</script>";
        }
        $data = [];
        // Get all properties
        foreach($skus as $resultSku) {
            $skuData = [];
            foreach($resultSku->classMethodsGet() as $getProperty) {
                $getProperty = $getProperty[0];

                if (preg_match('/getSku/', $getProperty)) {
                    $skuData = array("Sku" => $resultSku->getSku());
                    continue;
                }
                $property = preg_replace('/^get/', '', $getProperty);

                $objvalue = $resultSku->$getProperty();
                $objvalue === NULL ? $value = 'Empty' : $value = $objvalue->$getProperty();
                
                $skuData[$property] = $value;
            }
            array_push($data, $skuData);
        }
        if($request->getContentType() === "json") {
            return new JsonResponse($data, Response::HTTP_OK);
        }
        return $this->render('base.html.twig', [
            'data' => $data,
        ]);
    }
    #endregion

    #region edit_sku
    /**
     * @Route("/edit/{sku}", name="edit_sku", methods={"GET", "POST", "PATCH"})
     */
    public function updateSku($sku, Request $request): Response
    {   
        $editSku = $this->skuRepository->findOneBy(['Sku' => $sku]);
        
        if (!$editSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        // For API
        if($request->getContentType() === "json") {
            $data = json_decode($request->getContent(), true);
        
            foreach($editSku->classMethodsSet() as $array) {
                foreach($array as $setProperty) {
                    $property = preg_replace('/^set/', '', $setProperty);
                    $getProperty = preg_replace('/^set/', 'get', $setProperty);
                    $class = "App\Entity\\$property";
                    $class = new $class();

                    // Condition of properties
                    if (!isset($data[$property])) {
                        continue;
                    }
                    if (preg_match('/setSku/', $setProperty)) {
                        $skuValue = $data[$property];
                        
                        if (empty($skuValue) || $skuValue <= 0) {
                            throw new NotFoundHttpException('Sku is required !');
                        }
                        $editSku->$setProperty($skuValue);
                        continue;
                    }
                    if ($editSku->$getProperty() != NULL) {
                        $value = $editSku->$getProperty()->$setProperty($data[$property]);
                    } else {
                        $value = $class->$setProperty($data[$property]);
                    }
                    switch (gettype($value->$getProperty())) {
                        case 'double':
                            if ($value->$getProperty() <= 0) {
                                throw new NotFoundHttpException('Error '.$property.' parameters !');
                            }
                            break;
                        case 'integer':
                            if ($value->$getProperty() < 0) {
                                throw new NotFoundHttpException('Error '.$property.' parameters !');
                            }
                            break;
                    }
                    $editSku->$setProperty($value);
                }
            }
            $this->skuRepository->updateSku($editSku, $data);
            
            return new JsonResponse(['Status' => 'Sku: '. $editSku->getSku().' Edited !']);
        }
        // For HTML
        $form = $this->createForm(SkuType::class, $editSku);

        try{
            $form->handleRequest($request);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" 
                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 
                        0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 
                        5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                    />
                </svg>
                <?php echo $message ?>
            </div>
            <?php
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Condition of properties
            foreach($data->classMethodsGet() as $array) {
                foreach($array as $getProperty) {
                    $property = preg_replace('/^get/', '', $getProperty);

                    if (preg_match('/getSku/', $getProperty)) {
                        $skuValue = $data->$getProperty();
                        
                        if (empty($skuValue) || $skuValue <= 0) {
                            throw new NotFoundHttpException('Sku is required !');
                        }
                        continue;
                    }
                    $objvalue = $data->$getProperty();
                    $objvalue === NULL ? true : $value = $objvalue->$getProperty();

                    if (isset($value)) {
                        switch (gettype($value)) {
                            case 'double':
                                if ($value <= 0) {
                                    throw new NotFoundHttpException('Error '.$property.' parameters !');
                                }
                                break;
                            case 'integer':
                                if ($value < 0) {
                                    throw new NotFoundHttpException('Error '.$property.' parameters !');
                                }
                                break;
                        }
                    }
                }
            }
            $this->skuRepository->updateSku($editSku, $data);
            
            return $this->redirectToRoute('get_all_sku', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('edit.html.twig', [
            'Sku' => $editSku,
            'form' => $form,
        ]);
    }
    #endregion

    #region delete_sku
    /**
     * @Route("/delete/{sku}", name="delete_sku", methods={"GET", "DELETE"})
     */
    public function remove(int $sku, Request $request): Response
    {
        $resultSku = $this->skuRepository->findOneBy(['Sku' => $sku]);

        if (!$resultSku) {
            throw $this->createNotFoundException(
                'Sku '.$sku.' not found ! '
            );
        }
        $this->skuRepository->removeSku($resultSku);
        
        if($request->getContentType() === "json") {
            return new JsonResponse(['Status' => 'Sku deleted'], Response::HTTP_NO_CONTENT);
        }
        return $this->redirectToRoute('get_all_sku', [], Response::HTTP_SEE_OTHER);
    }
    #endregion
}
