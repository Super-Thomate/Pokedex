<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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
    $params                  =
              array (   "id" => $id
                      , "pokemon" => array (     "name" => "TEST"
                                             ,  "type1" => "plante"
                                             ,  "type2" => "poison"
                                             , "pokeId" => $this -> formatId ($id)
                                           )
                    ) ;
    return $this -> render ('pokedex/pokemon.html.twig', $params) ;
  }
  /**
   * @Route("/", name="home")
   */
  public function index () {
    return $this -> render ('base/home.html.twig', array ()) ;
  }
  /**
   * @Route("/search", name="search")
   */
  public function search (Request $request) {
    // POST
    // $request->request->get('page');
    $handler                 = $request -> request -> get ("handler") ;
    if ($handler == "search") {
      //
    }
    $typeArray1              =
              array (   0 => "acier"
                      , 1 => "combat"
                      , 2 => "dragon"
                      , 3 => "eau"
                      , 4 => "electrik"
                      , 5 => "fee"
                      , 6 => "feu"
                      , 7 => "glace"
                      , 8 => "insecte"
                    ) ;
    $typeArray2              =
             array (
                        0 => "normal"
                      , 1 => "plante"
                      , 2 => "poison"
                      , 3 => "psy"
                      , 4 => "roche"
                      , 5 => "sol"
                      , 6 => "spectre"
                      , 7 => "tenebres"
                      , 8 => "vol"
                    ) ;
    $params                  =
              array (   "types1" => $typeArray1
                      , "types2" => $typeArray2
                    ) ;
    return $this -> render ('base/search.html.twig', $params) ;
  }

  protected function formatId ($id) {
    return (   $id < 10
             ? "00".$id
             : (   $id < 100
                 ? "0".$id
                 : $id
               )
           ) ;
  }
}
