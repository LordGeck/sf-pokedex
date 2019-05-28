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
use Doctrine\Common\Persistence\ObjectManager;

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
     * @var Symfony\Component\Stopwatch\Stopwatch
     */
    private $stopwatch;

    /**
     * @var Doctrine\Common\Persistence\ObjectManager
     */
    private $om;

    /**
     * PokedexController constructor.
     * @param PokemonRepository $pokemonRepository
     * @param AttackRepository $attackRepository
     * @param LoggerInterface $logger
     * @param Request $request
     */
    public function __construct(PokemonRepository $pokemonRepository, AttackRepository $attackRepository, LoggerInterface $logger, RequestStack $requestStack, Stopwatch $stopwatch, ObjectManager $om)
    {
        $this->pokemonRepository = $pokemonRepository;
        $this->attackRepository = $attackRepository;
        $this->logger = $logger;
        $this->request = $requestStack->getCurrentRequest();
        $this->stopwatch = $stopwatch;
        $this->om = $om;
    }

    /**
     * @param $routeName
     * @param Request $request
     * @param Stopwatch $stopwatch
     */
    public function logPerformance($routeName){
        $event = $this->stopwatch->stop($routeName);
        $this->logger->info('Completed route "'.$routeName.'". Path : '.$this->request->getRequestUri().'. Duration : '.$event->getDuration().' ms, Max Memory Usage : '.$event->getMemory().' octets');
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $this->stopwatch->start('home');

        // log route name, duration and max memory usage
        $this->logPerformance('home');

        return $this->render('pokedex/index.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/pokemon", name="pokemon_grid")
     */
    public function pokemonGrid()
    {
        $this->stopwatch->start('pokemon_grid');

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
        $this->logPerformance('pokemon_grid');

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
        $this->stopwatch->start('pokemon_detail');

        $pokemonDetail = $this->pokemonRepository->findDetail($noPokedex);

        $slotsRepository = $this->getDoctrine()->getRepository(AttackSlot::class);
        $pokemonAttackSlots = $slotsRepository->findByPokemon($noPokedex);

        if(!$pokemonDetail){
            throw $this->createNotFoundException(
                'pokemon detail infos was not found'
            );
        }

        // log route name, duration and max memory usage
        $this->logPerformance('pokemon_detail');

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
        $this->stopwatch->start('attack_list');

        $attacks = $this->attackRepository->findAll();

        if (!$attacks) {
            throw $this->createNotFoundException(
                'No attack found.'
            );
        }

        // log route name, duration and max memory usage
        $this->logPerformance('attack_list');

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
        $this->stopwatch->start('attack_detail');

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
        $this->logPerformance('attack_detail');

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
        $this->stopwatch->start('admin_attack');

        $attacks = $this->attackRepository->findAll();

        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack');

        return $this->render('admin/attack.html.twig', [
            'attacks' => $attacks
        ]);
    }

    /**
     * @Route("/admin/attack/create", name="admin_attack_create")
     */
    public function attackAdminCreate()
    {
        $this->stopwatch->start('admin_attack_create');

        $attack = new Attack();
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->om->persist($attack);
            $this->om->flush();
            return $this->redirectToRoute('admin_attack');
        }

        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack_create');

        return $this->render('admin/attack_create.html.twig', array(
            'attack' => $attack,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/attack/{id}", name="admin_attack_edit", requirements={"id":"\d+"}, methods={"GET","POST"})
     */
    public function attackAdminEdit(Attack $attack)
    {
        $this->stopwatch->start('admin_attack_edit');

        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->om->flush();
            return $this->redirectToRoute('admin_attack');
        }


        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack_edit');

        return $this->render('admin/attack_edit.html.twig', array(
            'attack' => $attack,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/attack/{id}", name="admin_attack_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param Attack $attack
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function attackAdminDelete(Attack $attack)
    {
        $this->stopwatch->start('admin_attack_delete');

        if ($this->isCsrfTokenValid('delete' . $attack->getId(), $this->request->get('_token'))) {
            $this->om->remove($attack);
            $this->om->flush();
        }

        // log route name, duration and max memory usage
        $this->logPerformance('admin_attack_delete');

        return $this->redirectToRoute('admin_attack');
    }

    /**
     * @Route("/admin/pokemon", name="admin_pokemon")
     */
    public function pokemonAdminPanel()
    {
        $this->stopwatch->start('admin_pokemon');

        $pokemons = $this->pokemonRepository->findAllWithDescription();

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon');

        return $this->render('admin/pokemon.html.twig', [
            'pokemons' => $pokemons
        ]);
    }

    /**
     * @Route("/admin/pokemon/create", name="admin_pokemon_create")
     */
    public function pokemonAdminCreate()
    {
        $this->stopwatch->start('admin_pokemon_create');

        $pokemon = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->om->persist($pokemon);
            $this->om->flush();
            return $this->redirectToRoute('admin_pokemon');
        }

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon_create');

        return $this->render('admin/pokemon_create.html.twig', array(
            'pokemon' => $pokemon,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/pokemon/{id}", name="admin_pokemon_edit", requirements={"id":"\d+"}, methods={"GET","POST"})
     * @param Pokemon $pokemon
     */
    public function pokemonAdminEdit(Pokemon $pokemon)
    {
        $this->stopwatch->start('admin_pokemon_edit');

        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->om->flush();
            return $this->redirectToRoute('admin_pokemon');
        }

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon_edit');

        return $this->render('admin/pokemon_edit.html.twig', array(
            'pokemon' => $pokemon,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/pokemon/{id}", name="admin_pokemon_delete", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param Pokemon $pokemon
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function pokemonAdminDelete(Pokemon $pokemon)
    {
        $this->stopwatch->start('admin_pokemon_delete');

        if ($this->isCsrfTokenValid('delete' . $pokemon->getId(), $this->request->get('_token'))) {
            $this->om->remove($pokemon);
            $this->om->flush();
        }

        // log route name, duration and max memory usage
        $this->logPerformance('admin_pokemon_delete');

        return $this->redirectToRoute('admin_pokemon');
    }
    
}

