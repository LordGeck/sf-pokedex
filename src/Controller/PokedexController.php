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

        if (!$pokemons) {
            throw $this->createNotFoundException(
                'No pokemon found.'
            );
        }

        // prefixes for retrieving images
        $prefixes = array();
        foreach ($pokemons as $pokemon){
//            dump($pokemon);
            $prefixes[] = str_pad($pokemon['no_pokedex'], 3, '0', STR_PAD_LEFT);
        }

        dump($prefixes);

        return $this->render('pokedex/pokemon_grid.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemons' => $pokemons,
            'prefixes' => $prefixes
        ]);
    }

    /**
     * @Route("/pokemon/{noPokedex}", name="pokemon_detail")
     */
    public function pokemonDetail($noPokedex)
    {
        $repository = $this->getDoctrine()->getRepository(Pokemon::class);
        $pokemonDetail = $repository->findDetail($noPokedex);

        dump($pokemonDetail);

        $slotsRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $pokemonAttackSlots = $slotsRepository->findByPokemon($noPokedex);

        if(!$pokemonDetail){
            throw $this->createNotFoundException(
                'pokemon detail infos was not found'
            );
        }

        return $this->render('pokedex/pokemon_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemon' => $pokemonDetail,
            'attack_slots' => $pokemonAttackSlots
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
