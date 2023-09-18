<?php

namespace App\Controller;

use App\Entity\Product;
use App\Provider\CalculatePriceParams;
use App\Provider\PurchaseParams;
use App\Services\payment\Payment;
use App\Services\price\CouponCodeCalc;
use App\Services\price\TaxNumberCalc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $response = new Response;

        $request = $request->toArray();

        $params = new CalculatePriceParams($request);

        $product = $request['product'];
        $taxNumber = $request['taxNumber'];
        $couponCode = $request['couponCode'];

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

        $repository = $entityManager->getRepository(Product::class);
        $product = $repository->find($product);

        $price = $product->getPrice();

        $handler = CouponCodeCalc::getInstance($couponCode, $price);
        $total = $handler->calculate();
        $handler->setNext(new TaxNumberCalc($taxNumber, $total));
        $total = $handler->calculate();

        return $response;

    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $response = new Response;

        $request = $request->toArray();

        $params = new PurchaseParams($request);

        $product = $request['product'];
        $taxNumber = $request['taxNumber'];
        $couponCode = $request['couponCode'];
        $paymentProcessor = $request['paymentProcessor'];

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

        $repository = $entityManager->getRepository(Product::class);
        $product = $repository->find($product);

        $price = $product->getPrice();

        $handler = CouponCodeCalc::getInstance($couponCode, $price);
        $total = $handler->calculate();
        $handler->setNext(new TaxNumberCalc($taxNumber, $total));
        $total = $handler->calculate();

        Payment::pay($paymentProcessor, $total);

        return $response;

    }
}
