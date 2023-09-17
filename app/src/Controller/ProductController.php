<?php

namespace App\Controller;

use App\Provider\PurchaseParams;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Provider\CalculatePriceParams;

class ProductController extends AbstractController
{
    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(Request $request, ValidatorInterface $validator)
    {
        $response = new Response;

        $params = new CalculatePriceParams($request->toArray());

        $errors = $validator->validate($params);

        if (!$request || count($errors) > 0) {

            $response->setStatusCode(400);

            $errorsList = [];

            foreach ($errors as $error) {
                $errorsList[] = [$error->getPropertyPath() => $error->getMessage()];
            }

            $response->setContent($this->json(['errors' => $errorsList]));

            return $response;

        }

        return $response;

    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request, ValidatorInterface $validator)
    {
        $response = new Response;

        $params = new PurchaseParams($request->toArray());

        $errors = $validator->validate($params);

        if (!$request || count($errors) > 0) {

            $response->setStatusCode(400);

            $errorsList = [];

            foreach ($errors as $error) {
                $errorsList[] = [$error->getPropertyPath() => $error->getMessage()];
            }

            $response->setContent($this->json(['errors' => $errorsList]));

            return $response;

        }

        return $response;

    }
}
