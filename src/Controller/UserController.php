<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{username}", name="user_show")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(User $user)
    {
        /*foreach ($user->getProducts() as $product) {
            dump($product->getName());
        }*/

        return $this->render('user/show.html.twig', [
            
            'user' => $user
        ]);
    }
}
