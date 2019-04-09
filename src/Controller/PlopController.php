<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlopController extends AbstractController
{
    /**
     * @Route("/plop", name="plop")
     */
    public function index()
    {
        return $this->render('plop/index.html.twig', [
            'controller_name' => 'PlopController',
        ]);
    }
}
