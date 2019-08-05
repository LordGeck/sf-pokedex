<?php

namespace App\Controller;

use App\Entity\Attack;
use App\Entity\Pokemon;
use App\Entity\PokemonSearch;
use App\Entity\Contact;
use App\Form\AttackType;
use App\Form\PokemonType;
use App\Form\ContactType;
use App\Repository\AttackRepository;
use App\Repository\PokemonRepository;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AttackSlot;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Common\Persistence\ObjectManager;
use App\Controller\Utils;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\PokemonSearchType;

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
     * @Route("/", name="home")
     */
    public function index()
    {
        $this->stopwatch->start('home');

        // log route name, duration and max memory usage
        Utils::logPerformance('home', $this->stopwatch, $this->logger, $this->request);

        return $this->render('pokedex/index.html.twig', [
            'controller_name' => 'PokedexController',
        ]);
    }

    /**
     * @Route("/pokemon", name="pokemon_grid")
     */
    public function pokemonGrid(PaginatorInterface $paginator)
    {
        $this->stopwatch->start('pokemon_grid');

        $search = new PokemonSearch();
        $form = $this->createForm(PokemonSearchType::class, $search);
        $form->handleRequest($this->request);

        // use of injected repo
        $pokemons = $paginator->paginate(
            $this->pokemonRepository->findAllWithDescriptionQuery($search),
            $this->request->query->getInt('page', 1),
            15
        );

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
        Utils::logPerformance('pokemon_grid', $this->stopwatch, $this->logger, $this->request);

        return $this->render('pokedex/pokemon_grid.html.twig', [
            'controller_name' => 'PokedexController',
            'pokemons' => $pokemons,
            'prefixes' => $prefixes,
            'form' => $form->createView()
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
        Utils::logPerformance('pokemon_detail', $this->stopwatch, $this->logger, $this->request);

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
        Utils::logPerformance('attack_list', $this->stopwatch, $this->logger, $this->request);

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
        Utils::logPerformance('attack_detail', $this->stopwatch, $this->logger, $this->request);

	    return $this->render('pokedex/attack_detail.html.twig', [
            'controller_name' => 'PokedexController',
            'attack' => $attack,
            'attackSlots' => $attackSlots
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(ContactNotification $notification)
    {
        $this->stopwatch->start('contact');

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($this->request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $notification->notify($contact);
                $this->addFlash('success', 'Votre email a bien été envoyé');
            }
            else {
                $this->addFlash('failure', 'Informations non valides, l\'email n\'a pas pu être envoyé');
            }
            return $this->redirectToRoute('contact');
        }

        return $this->render('pokedex/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

