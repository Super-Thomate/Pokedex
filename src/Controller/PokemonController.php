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
  /**
   * @Route("/pokemon/all", name="all_pokemon")
   */
  public function allPokemon (Request $request) {
    // POST
    // $request->request->get('page');
    $params                  = array () ;
    $file                    = "csv/PokemonFr.csv" ;
    $allPokemon              = array () ;
    $firstGen                = array () ;
    $handle                  = fopen ($file, "r") ;
    $bool                    = file_exists ($file) ;
    $title                   = fgetcsv ($handle) ;
    $count                   = 0 ;
    while ($csv = fgetcsv ($handle)) {
      if (    is_null ($csv [1])
           || ! strlen ($csv [1])
         ) {
        $allPokemon        [count ($allPokemon)] =
              array (           "id" => $this -> formatId ($csv [0])
                      ,       "name" => $csv [2]
                      , "generation" => $csv [3]
                      ,      "type1" => strtolower ($csv [4])
                      ,      "type2" => strtolower ($csv [5])
                    ) ;
        if ($csv [3] == 1) {
          $firstGen          [count ($firstGen)] =
              array (           "id" => $this -> formatId ($csv [0])
                      ,       "name" => $csv [2]
                      , "generation" => $csv [3]
                      ,      "type1" => strtolower ($csv [4])
                      ,      "type2" => strtolower ($csv [5])
                    ) ;
        }
      }
      $count++ ;
    }
    // echo "File (".count ($allPokemon).") : <pre>".print_r ($allPokemon, true)."</pre><br>" ;
    fclose ($handle) ;
    $ordered                 = $this -> sortArray ($allPokemon) ;
    //echo "Ordered (".count ($ordered).") : <pre>".print_r ($ordered, true)."</pre><br>" ;
    $params     ["pokemons"] = $ordered ;
    return $this -> render ('pokemon/all.html.twig', $params) ;
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
  protected function sortArray ($array) {
    $arrayTmp                = array () ;
    for ($i = 0 ; $i < count ($array) ; $i++) {
      $index                 = intval ($array [$i]["id"]) ;
      $arrayTmp [$index]     = $array [$i] ;
    }
    ksort ($arrayTmp) ;
    return $arrayTmp ;
  }
}
