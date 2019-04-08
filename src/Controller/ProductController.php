<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="product_create")
     * @param Request $request
     * @return Response
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
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
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

    /**
     * Créer la route /product où on affichera tous les produits de la base de données.
     * On utilisera les cards de Bootstrap.
     *
     * @Route("/product", name="product_list")
     * @param ProductRepository $repository
     * @return Response
     */
    public function list(ProductRepository $repository)
    {
        $products = $repository->findAll();

        return $this->render('product/list.html.twig', [
           'products' => $products
        ]);
    }
}
