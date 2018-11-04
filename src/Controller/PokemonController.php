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
    $handle                  = fopen ($file, "r") ;
    $bool                    = file_exists ($file) ;
    $title                   = fgetcsv ($handle) ;
    while ($csv = fgetcsv ($handle)) {
      if (    is_null ($csv [1])
           || ! strlen ($csv [1])
         ) {
        $allPokemon        [count ($allPokemon)] =
              array (           "id" => $csv [0]
                      ,       "name" => $csv [2]
                      , "generation" => $csv [3]
                      ,      "type1" => $csv [4]
                      ,      "type2" => $csv [5]
                    ) ;
      }
    }
    echo "File (".count ($allPokemon).") : <pre>".print_r ($allPokemon, true)."</pre><br>" ;
    fclose ($handle) ;
    return $this -> render ('pokemon/index.html.twig', $params) ;
  }
}
