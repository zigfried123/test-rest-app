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

        try {
            $total = (new Price)->calculate($taxNumber, $couponCode, $price);
        } catch (CouponException $e) {
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

        try {
            $total = (new Price)->calculate($taxNumber, $couponCode, $price);
        } catch (CouponException $e) {
            return $response->setContent($this->json(['error' => $e->getMessage()]));
        }

        try {
            (new PaymentAdapter)->pay($paymentProcessor, $total);
        } catch (\Exception $e) {
            return $response->setContent($this->json(['error' => $e->getMessage()]));
        }

        return $response;

    }
}
