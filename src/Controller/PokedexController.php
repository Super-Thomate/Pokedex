<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokedexController extends AbstractController
{
    /**
     * @Route("/pokedex", name="pokedex")
     */
    public function pokedex()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PokedexController.php',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this -> render ('base/base.html.twig', array ()) ;
    }
}
