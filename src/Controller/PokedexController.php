<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PokedexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('pokedex/index.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/pokemon", name="pokemon_grid")
     */
    public function pokemonGrid()
    {
        return $this->render('pokedex/pokemon_grid.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/pokemon/{id}", name="pokemon_detail")
     */
    public function pokemonDetail($id)
    {
        return $this->render('pokedex/pokemon_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'id' => $id,
        ]);
    }

    /**
     * @Route("/attack", name="attack_list")
     */
    public function attackList()
    {
        return $this->render('pokedex/attack_list.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/attack/{id}", name="attack_detail")
     */
    public function attackDetail($id)
    {
        return $this->render('pokedex/attack_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'id' => $id,
        ]);
    }

    /**
     * @Route("/create}", name="create_resource")
     */
    public function createResource()
    {
        return $this->render('pokedex/create_resource.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }
}
