<?php

namespace App\Controller;

use App\Entity\Attack;
use App\Entity\Pokemon;
use App\Form\AttackType;
use App\Form\PokemonType;
use App\Repository\AttackRepository;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AttackSlot;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var \Symfony\Component\HttpFoundation\Request|null
     */
    private $request;

    /**
     * PokedexController constructor.
     * @param PokemonRepository $pokemonRepository
     * @param AttackRepository $attackRepository
     * @param LoggerInterface $logger
     * @param Request $request
     */
    public function __construct(PokemonRepository $pokemonRepository, AttackRepository $attackRepository, LoggerInterface $logger, RequestStack $requestStack)
    {
        $this->pokemonRepository = $pokemonRepository;
        $this->attackRepository = $attackRepository;
        $this->logger = $logger;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param $routeName
     * @param Request $request
     * @param Stopwatch $stopwatch
     */
    public function logPerformance($routeName, $request, $stopwatch){
        $event = $stopwatch->stop($routeName);
        $this->logger->info('Completed route "'.$routeName.'". Path : '.$request->getBasePath().'. Duration : '.$event->getDuration().' ms, Max Memory Usage : '.$event->getMemory().' octets');
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('home');

        // log route name, duration and max memory usage
        $this->logPerformance('home', $this->request, $stopwatch);

        return $this->render('pokedex/index.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/pokemon", name="pokemon_grid")
     */
    public function pokemonGrid()
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('pokemon_grid');

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

        // log route name, duration and max memory usage
        $this->logPerformance('pokemon_grid', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('pokemon_detail');

        $pokemonDetail = $this->pokemonRepository->findDetail($noPokedex);

        $slotsRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $pokemonAttackSlots = $slotsRepository->findByPokemon($noPokedex);

        if(!$pokemonDetail){
            throw $this->createNotFoundException(
                'pokemon detail infos was not found'
            );
        }

        // log route name, duration and max memory usage
        $this->logPerformance('pokemon_detail', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('attack_list');

        $attacks = $this->attackRepository->findAll();

        if (!$attacks) {
            throw $this->createNotFoundException(
                'No attack found.'
            );
        }

        // log route name, duration and max memory usage
        $this->logPerformance('attack_list', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('attack_detail');

        $attack = $this->attackRepository->find($id);
        // load related attack slots as well
        $attackSlotRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $attackSlots = $attackSlotRepository->findByAttack($attack->getId());

	    if(!$attack){
		    throw $this->createNotFoundException(
			    'attack of id '.$id.' was not found'
		    );
        }

        // log route name, duration and max memory usage
        $this->logPerformance('attack_detail', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('admin_attack');

        $attacks = $this->attackRepository->findAll();

        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack', $this->request, $stopwatch);

        return $this->render('admin/attack.html.twig', [
            'attacks' => $attacks
        ]);
    }

    /**
     * @Route("/admin/attack/{id}", name="admin_attack_edit", requirements={"id":"\d+"})
     */
    public function attackAdminEdit(Attack $attack)
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('admin_attack_edit');

        $form = $this->createForm(AttackType::class, $attack);

        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack_edit', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('admin_pokemon');

        $pokemons = $this->pokemonRepository->findAllWithDescription();

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon', $this->request, $stopwatch);

        return $this->render('admin/pokemon.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    /**
     * @Route("/admin/pokemon/{id}", name="admin_pokemon_edit", requirements={"id":"\d+"})
     */
    public function pokemonAdminEdit(Pokemon $pokemon)
    {
        $stopwatch = new Stopwatch();
        $stopwatch->start('admin_pokemon_edit');

        $form = $this->createForm(PokemonType::class, $pokemon);

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon_edit', $this->request, $stopwatch);

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
        $stopwatch = new Stopwatch();
        $stopwatch->start('create_resource');

        // log route name, duration and max memory usage
        $this->logPerformance('create_resource', $this->request, $stopwatch);

        return $this->render('pokedex/create_resource.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }
}
