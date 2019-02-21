<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon;
use App\Entity\Attack;

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
        $repository = $this->getDoctrine()->getRepository(Pokemon::class);
        $pokemons = $repository->findAll();

        if (!$pokemons) {
            throw $this->createNotFoundException(
                'No pokemon found.'
            );
        }

        return $this->render('pokedex/pokemon_grid.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemons' => $pokemons,
        ]);
    }

    /**
     * @Route("/pokemon/{id}", name="pokemon_detail")
     */
    public function pokemonDetail($id)
    {
        $repository = $this->getDoctrine()->getRepository(Pokemon::class);
        $pokemon = $repository->find($id);

        if(!$pokemon){
            throw $this->createNotFoundException(
                'pokemon was not found'
            );
        }

        return $this->render('pokedex/pokemon_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemon' => $pokemon,
        ]);
    }

    /**
     * @Route("/attack", name="attack_list")
     */
    public function attackList()
    {
        $repository = $this->getDoctrine()->getRepository(Attack::class);
        $attacks = $repository->findAll();

        if (!$attacks) {
            throw $this->createNotFoundException(
                'No attack found.'
            );
        }


        return $this->render('pokedex/attack_list.html.twig', [
            'controller_name' => 'PokedexController',
            'attacks' => $attacks,
        ]);
    }

    /**
     * @Route("/attack/{id}", name="attack_detail")
     */
    public function attackDetail($id)
    {
	$repository = $this->getDoctrine()->getRepository(Attack::class);
	$attack = $repository->find($id);

	if(!$attack){
		throw $this->createNotFoundException(
			'attack of id '.$id.' was not found'
		);
	}

	return $this->render('pokedex/attack_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'attack' => $attack,
        ]);
    }

    /**
     * @Route("/create", name="create_resource")
     */
    public function createResource()
    {
        return $this->render('pokedex/create_resource.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }
}
