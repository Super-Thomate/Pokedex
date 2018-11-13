<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }
    /**
     * @return [] Returns an array of array (i.e. a raw data set)
     */
    public function findSpec ($params) {
      $conn                  = $this -> getEntityManager () -> getConnection () ;
      $sql                   = 
              "select   * \n".
              " from    pokemon\n".
              "" ;
      $values                = array () ;
      // TYPES
      $types                 = $params ["types"] ;
      $operation             = $params ["operation"] ;
      $or                    = $params ["or"] ;
      $tmpTypes              = "" ;
      switch ($operation) {
        case  'mono':
          if (count ($types)) {
            // There are types
            for ($Nt = 0 ; $Nt < count ($types) ; $Nt++) {
              if (strlen ($types [$Nt])) {
                if (! strlen ($tmpTypes))
                  $tmpTypes     .= "\n" ;
                else
                  $tmpTypes     .= "      or \n" ;
                $tmpTypes       .= 
                            "         (\n".
                            "               type1 like :type_".$Nt."\n".
                            "           and\n".
                            "               (type2 is null or type2 = '')\n".
                            "         )\n" ;
                  $values      ["type_".$Nt] = $types [$Nt] ;
                }
              }
          } else {
            $tmpTypes         .=
                 "         (\n".
                 "              type2 is null\n".
                 "           or\n".
                 "              type2 = ''\n".
                 "         )\n".
                 "" ;
          }
        break ;
        case 'double':
          if (count ($types)) {
            if (strlen ($or) || count ($types) == 1) {
              for ($Nt = 0 ; $Nt < count ($types) ; $Nt++) {
                if (strlen ($types [$Nt])) {
                  if (! strlen ($tmpTypes))
                    $tmpTypes     .= "\n" ;
                  else
                    $tmpTypes     .= "      or \n" ;
                  $tmpTypes       .= 
                              "         (\n".
                              "              (     type1 like :type_".$Nt."\n".
                              "                and\n".
                              "                    (type2 is not null and type2 <> '')\n".
                              "              )\n".
                              "           or\n".
                              "              (\n".
                              "                type2 like :type_".$Nt."\n".
                              "              )\n".
                              "         )\n" ;
                    $values      ["type_".$Nt] = $types [$Nt] ;
                }
              }
            } else {
              for ($Nt = 0 ; $Nt < count ($types) ; $Nt++) {
                for ($Ntd = 0 ; $Ntd < count ($types) ; $Ntd++) {
                  if ($Nt != $Ntd) {
                    if (! strlen ($tmpTypes))
                      $tmpTypes     .= "\n" ;
                    else
                      $tmpTypes     .= "      or \n" ;
                    $tmpTypes       .= 
                                "         (\n".
                                "              (     type1 like :type_".$Nt."\n".
                                "                and\n".
                                "                    type2 like :type_".$Nt."_".$Ntd."\n".
                                "              )\n".
                                "         )\n" ;
                    $values         ["type_".$Nt."_".$Ntd] = $types [$Ntd] ;
                  }
                }
                $values  ["type_".$Nt] = $types [$Nt] ;
              }
            }
          } else {
            $tmpTypes       .=
              "         (\n".
              "               type2 is not null\n".
              "           and\n".
              "               type2 <> ''\n".
              "         )\n".
              "" ;
          }
        break ;
        default:
         if (count ($types)) {
            // There are types
            for ($Nt = 0 ; $Nt < count ($types) ; $Nt++) {
              if (strlen ($types [$Nt])) {
                if (! strlen ($tmpTypes))
                  $tmpTypes     .= "\n" ;
                else
                  $tmpTypes     .= "      or \n" ;
                $tmpTypes       .= 
                            "         (\n".
                            "              type1 like :type_".$Nt."\n".
                            "           or\n".
                            "              type2 like :type_".$Nt."\n".
                            "         )\n" ;
                  $values      ["type_".$Nt] = $types [$Nt] ;
                }
              }
          }
      }
      // GENERATIONS
      $generations           = $params ["generations"] ;
      $tmpGenerations        = "" ;
      if (count ($generations)) {
        // There are generations
        for ($Ng = 0 ; $Ng < count ($generations) ; $Ng++) {
          if (strlen ($generations [$Ng])) {
            if (! strlen ($tmpGenerations))
              $tmpGenerations     .= "\n" ;
            else
              $tmpGenerations     .= "      or \n" ;
            $tmpGenerations       .= 
                        "         (\n".
                        "              generation like :generation_".$Ng."\n".
                        "         )\n" ;
            $values      ["generation_".$Ng] = $generations [$Ng] ;
          }
        }
      }
      // NAME
      $name                  = $params ["name"] ;
      $tmpName               = "" ;
      if (strlen ($name)) {
        $tmpName            .=
                        "         (\n".
                        "              name like :name\n".
                        "         )\n" ;
            $values       ["name"] = "%".$name."%" ;
      }
      if (strlen ($tmpTypes)) {
        $sql              .= "where\n" ;
        $sql              .= "(\n".$tmpTypes.")\n" ;
      }
      // CREATE THE QYUERY
      if (strlen ($tmpGenerations)) {
        if (!strlen ($tmpTypes))
          $sql            .= "where\n" ;
        else
          $sql            .= "and\n" ;
        $sql              .= "(\n".$tmpGenerations.")\n" ;
      }
      if (strlen ($tmpName)) {
        if (    !strlen ($tmpTypes)
             && !strlen ($tmpGenerations)
           )
          $sql            .= "where\n" ;
        else
          $sql            .= "and\n" ;
        $sql              .= "(\n".$tmpName.")\n" ;
      }
      $query                 = $conn -> prepare ($sql) ;
      $query -> execute ($values) ;
      return $query -> fetchAll () ;
      //return $sql ;
    }
}
