<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Pokemon ;
use App\Entity\PokeSprite ;

class PokemonController extends AbstractController {
  /**
   * @Route("/pokemon/add", name="add_pokemon")
   */
  public function addPokemon (Request $request) {
    // POST
    // $request->request->get('page');
    return $this -> render ('pokemon/index.html.twig', array ()) ;
  }
}
