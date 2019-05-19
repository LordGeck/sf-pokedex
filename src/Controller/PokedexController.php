<?php

namespace App\Controller;

use App\Entity\Attack;
use App\Entity\Pokemon;
use App\Form\AttackType;
use App\Form\PokemonType;
use App\Repository\AttackRepository;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AttackSlot;

/**
 * Class PokedexController
 * @package App\Controller
 */
class PokedexController extends AbstractController
{
    /**
     * @var PokemonRepository
     */
    private $pokemonRepository;

    /**
     * @var AttackRepository
     */
    private $attackRepository;

    /**
     * PokedexController constructor.
     * @param PokemonRepository $pokemonRepository
     * @param AttackRepository $attackRepository
     */
    public function __construct(PokemonRepository $pokemonRepository, AttackRepository $attackRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
        $this->attackRepository = $attackRepository;
    }

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
        // use of injected repo
        $pokemons = $this->pokemonRepository->findAllWithDescription();

        if (!$pokemons) {
            throw $this->createNotFoundException(
                'No pokemon found.'
            );
        }

        // prefixes for retrieving images
        $prefixes = array();
        foreach ($pokemons as $pokemon){
            $prefixes[] = str_pad($pokemon['no_pokedex'], 3, '0', STR_PAD_LEFT);
        }

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
        $pokemonDetail = $this->pokemonRepository->findDetail($noPokedex);

        $slotsRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $pokemonAttackSlots = $slotsRepository->findByPokemon($noPokedex);

        if(!$attackSlots){
            throw $this->createNotFoundException(
                'attack slots for pokemon '.$id.' were not found'
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
        $attacks = $this->attackRepository->findAll();

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
        $attack = $this->attackRepository->find($id);
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
     * @Route("/admin/attack", name="admin_attack")
     */
    public function attackAdminPanel()
    {
        $attacks = $this->attackRepository->findAll();
        return $this->render('admin/attack.html.twig', [
            'attacks' => $attacks
        ]);
    }

    /**
     * @Route("/admin/attack/{id}", name="admin_attack_edit", requirements={"id":"\d+"})
     */
    public function attackAdminEdit(Attack $attack)
    {
        $form = $this->createForm(AttackType::class, $attack);
        return $this->render('admin/attack.edit.html.twig', array(
            'attack' => $attack,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/pokemon", name="admin_pokemon")
     */
    public function pokemonAdminPanel()
    {
        $pokemons = $this->pokemonRepository->findAllWithDescription();
        return $this->render('admin/pokemon.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    /**
     * @Route("/admin/pokemon/{id}", name="admin_pokemon_edit", requirements={"id":"\d+"})
     */
    public function pokemonAdminEdit(Pokemon $pokemon)
    {
        $form = $this->createForm(PokemonType::class, $pokemon);
        return $this->render('admin/pokemon.edit.html.twig', array(
            'pokemon' => $pokemon,
            'form' => $form->createView()
        ));
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
