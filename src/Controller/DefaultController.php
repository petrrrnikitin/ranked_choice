<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $entityManager = $this->managerRegistry->getManager();
        $list = $entityManager->getRepository(Product::class)->findAll();
        dd($list);
        return $this->render('main/default/index.html.twig', []);
    }

    /**
     * @Route("/product-add", methods="GET", name="addProduct")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function productAdd(Request $request): Response
    {
        $product = new Product();
        $product->setTitle('Test');
        $product->setDescription('smth');
        $product->setPrice(10);
        $product->setQuantity(1);

        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}
