<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon;
use App\Entity\Attack;
use App\Entity\AttackSlot;

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
        $pokemons = $repository->findAllWithDescription();

        var_dump($pokemons);

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
        //$pokemon = $repository->find($id);
        $pokemonDetail = $repository->findDetail($id);

        if(!$pokemonDetail){
            throw $this->createNotFoundException(
                'pokemon detail infos was not found'
            );
        }

        return $this->render('pokedex/pokemon_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemon' => $pokemonDetail,
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
	    $attackRepository = $this->getDoctrine()->getRepository(Attack::class);
        $attack = $attackRepository->find($id);
        // load related attack slots as well
        $attackSlotRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $attackSlots = $attackSlotRepository->findByAttack($attack->getId());

	    if(!$attack){
		    throw $this->createNotFoundException(
			    'attack of id '.$id.' was not found'
		    );
        }

	    return $this->render('pokedex/attack_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'attack' => $attack,
            'attackSlots' => $attackSlots
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
