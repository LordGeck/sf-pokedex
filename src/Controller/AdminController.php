<?php

namespace App\Controller;

use App\Entity\Attack;
use App\Entity\Pokemon;
use App\Form\AttackType;
use App\Form\PokemonType;
use App\Repository\AttackRepository;
use App\Repository\PokemonRepository;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AttackSlot;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Common\Persistence\ObjectManager;
use App\Controller\Utils;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
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
     * @Route("/admin/attack", name="admin_attack")
     */
    public function attackAdminPanel()
    {
        $this->stopwatch->start('admin_attack');

        $attacks = $this->attackRepository->findAll();

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_attack', $this->stopwatch, $this->logger, $this->request);

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
        $attack->setCreatedAt();
        $form = $this->createForm(AttackType::class, $attack);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->om->persist($attack);
            $this->om->flush();
            $this->addFlash('success', 'Créé avec succès');
            return $this->redirectToRoute('admin_attack');
        }

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_attack_create', $this->stopwatch, $this->logger, $this->request);

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
            $attack->setEditedAt();
            $this->om->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin_attack');
        }


        // log route name, duration and max memory usage
        Utils::logPerformance('admin_attack_edit', $this->stopwatch, $this->logger, $this->request);

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
            $this->addFlash('success', 'Supprimé avec succès');
        }

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_attack_delete', $this->stopwatch, $this->logger, $this->request);

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
        Utils::logPerformance('admin_pokemon', $this->stopwatch, $this->logger, $this->request);

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
            $pokemon->setCreatedAt();
            $this->om->persist($pokemon);
            $this->om->flush();
            $this->addFlash('success', 'Créé avec succès');
            return $this->redirectToRoute('admin_pokemon');
        }

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_pokemon_create', $this->stopwatch, $this->logger, $this->request);

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
            $pokemon->setEditedAt();
            $this->om->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin_pokemon');
        }

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_pokemon_edit', $this->stopwatch, $this->logger, $this->request);

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
            $this->addFlash('success', 'Supprimé avec succès');
        }

        // log route name, duration and max memory usage
        Utils::logPerformance('admin_pokemon_delete', $this->stopwatch, $this->logger, $this->request);

        return $this->redirectToRoute('admin_pokemon');
    }
 
}

