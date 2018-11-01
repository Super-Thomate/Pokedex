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
    $typeArray               =
              array (   "acier"
                      , "combat"
                      , "dragon"
                      , "eau"
                      , "electrik"
                      , "fee"
                      , "feu"
                      , "glace"
                      , "insecte"
                      , "normal"
                      , "plante"
                      , "poison"
                      , "psy"
                      , "roche"
                      , "sol"
                      , "spectre"
                      , "tenebres"
                      , "vol"
                    ) ;
    $params                  =
              array (   "types" => $typeArray
                      //, "" => ""
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
