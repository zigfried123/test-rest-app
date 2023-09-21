<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exception\CouponException;
use App\Provider\CalculatePriceParams;
use App\Provider\PurchaseParams;
use App\Service\payment\PaymentAdapter;
use App\Service\price\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentController extends AbstractController
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

        $product = isset($request['product']) ? $request['product'] : null;
        $taxNumber = isset($request['taxNumber']) ? $request['taxNumber'] : null;
        $couponCode = isset($request['couponCode']) ? $request['couponCode'] : null;

        $params = new CalculatePriceParams(compact('product', 'taxNumber', 'couponCode'));

        $errors = $validator->validate($params);

        if (count($errors) > 0) {

            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

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

        try {
            $total = (new Price)->calculate($taxNumber, $couponCode, $price);
        } catch (CouponException $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response->setContent($this->json(['error' => $e->getMessage()]));
        }

        return $response->setContent($this->json(['final price' => $total]));

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

        $product = isset($request['product']) ? $request['product'] : null;
        $taxNumber = isset($request['taxNumber']) ? $request['taxNumber'] : null;
        $couponCode = isset($request['couponCode']) ? $request['couponCode'] : null;
        $paymentProcessor = isset($request['paymentProcessor']) ? $request['paymentProcessor'] : null;

        $params = new PurchaseParams(compact('product', 'taxNumber', 'couponCode', 'paymentProcessor'));

        $errors = $validator->validate($params);

        if (count($errors) > 0) {

            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

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

        try {
            $total = (new Price)->calculate($taxNumber, $couponCode, $price);
        } catch (CouponException $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response->setContent($this->json(['error' => $e->getMessage()]));
        }

        try {
            (new PaymentAdapter)->pay($paymentProcessor, $total);
        } catch (\Exception $e) {
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response->setContent($this->json(['error' => $e->getMessage()]));
        }

        return $response;

    }
}
