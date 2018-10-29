<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PokedexController extends AbstractController {
  /**
   * @Route("/pokedex/{id}", name="pokemon_id")
   */
  public function pokedex ($id) {
    //
    $pokeId                = intval ($id) ;
    if ($pokeId == 0) {
      // Impossibru
       throw $this -> createNotFoundException ('The pokemon #'.$id.' does not exist') ;
    }
    return $this -> render ('pokedex/pokemon.html.twig', array ("id" => $id)) ;
  }
  /**
   * @Route("/", name="home")
   */
  public function index () {
      return $this -> render ('base/home.html.twig', array ()) ;
  }
}
