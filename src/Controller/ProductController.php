<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajouter le produit en BDD
            $manager = $this->getDoctrine()->getManager();

            $manager->persist($product);
            $manager->flush();
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show")
     * @param $id
     * @param ProductRepository $repository
     */
    public function show($id, ProductRepository $repository)
    {
        /*$product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);*/
        $product = $repository->find($id);

        // Et on ajoute par rapport à la surcharge pour le SEO de (show.html.twig) :
        if (!$product) {
            throw $this->createNotFoundException( /* On n'utilise pas :  return $this->createNotFoundException Car comme on relève une exception, alors c'ay throw. */
                'Le produit '.$id.' n\'existe pas'
            );
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
