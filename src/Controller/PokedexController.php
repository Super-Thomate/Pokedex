<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Entity\Pokemon;
use App\Entity\PokeSprite;

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
    $pokemon                 =
      $this -> getDoctrine ()
            -> getRepository (Pokemon::class)
            -> find ($id) ;
    if (! $pokemon) {
      throw $this -> createNotFoundException ('The pokemon #'.$id.' does not exist') ;
    }
    $params                  =
              array (        "id" => $id
                      , "pokemon" => $pokemon
                    ) ;
    return $this -> render ('pokedex/pokemon.html.twig', $params) ;
  }
  /**
   * @Route("/", name="home")
   */
  public function index () {
    $allPokemons             =
      $this -> getDoctrine ()
            -> getRepository (Pokemon::class)
            -> findAll ()
            ;
    
    $typeArray1              =
              array (   0 => "bug"
                      , 1 => "dark"
                      , 2 => "dragon"
                      , 3 => "electric"
                      , 4 => "fairy"
                      , 5 => "fighting"
                      , 6 => "fire"
                      , 7 => "flying"
                      , 8 => "ghost"
                    ) ;
    $typeArray2              =
             array (
                        0 => "grass"
                      , 1 => "ground"
                      , 2 => "ice"
                      , 3 => "normal"
                      , 4 => "poison"
                      , 5 => "psychic"
                      , 6 => "rock"
                      , 7 => "steel"
                      , 8 => "water"
                    ) ;
    $params                  =
              array (     "types1" => $typeArray1
                      ,   "types2" => $typeArray2
                      , "pokemons" => $allPokemons
                    ) ;
    return $this -> render ('base/home.html.twig', $params) ;
  }
  /**
   * @Route("/search", name="search")
   */
  public function search (Request $request) {
    // POST
    // $request->request->get('page');
    $name                    = $request -> request -> get ("name") ;
    $types                   = $request -> request -> get ("types") ;
    $generations             = $request -> request -> get ("generations") ;
    $operation               = $request -> request -> get ("operation") ;
    $or                      = $request -> request -> get ("or") ;
    $allTypes                = strlen ($types) ? explode ("|", $types) : array () ;
    $allGenerations          = strlen ($generations) ? explode ("|", $generations) : array ()  ;
    
    
    $params                  = array (   "name" => $name
                                       , "types" => $allTypes
                                       , "generations" => $allGenerations
                                       , "operation" => $operation
                                       , "or" => $or
                                     ) ;
    $allPokemons             = $this 
                                 -> getDoctrine () 
                                 -> getRepository (Pokemon::Class) 
                                 -> findSpec ($params) 
                                 ;
    return $this -> json ($allPokemons);
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
