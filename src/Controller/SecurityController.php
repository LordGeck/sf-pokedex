<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Stopwatch\Stopwatch;
use App\Repository\UserRepository;
use App\Repository\PokemonSlotRepository;


/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @var Symfony\Component\Stopwatch\Stopwatch
     */
    private $stopwatch;

    /**
     * @var Doctrine\Common\Persistence\ObjectManager
     */
    private $om;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PokemonSlotRepository
     */
    private $pokemonSlotRepository;

    /**
     * @var \Symfony\Component\HttpFoundation\Request|null
     */
    private $request;

    public function __construct(UserRepository $userRepository, Stopwatch $stopwatch, ObjectManager $om, LoggerInterface $logger, Request $request, PokemonSlotRepository $pokemonSlotRepository)
    {
        $this->userRepository = $userRepository;
        $this->stopwatch = $stopwatch;
        $this->om = $om;
        $this->logger = $logger;
        $this->request = $request;
        $this->pokemonSlotRepository = $pokemonSlotRepository;
    }

    /**
     * @Route("/login", name="login") 
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function userDashboard($userId)
    {
        $this->stopwatch->start('user_dashboard');

        // get user and pokemon slots
        $user = $this->userRepository->find($userId);

        if(!$user){
            throw $this->createNotFoundException(
                "User infos for userId $userId not found"
            );
        }

        // get infos from PokemonSlot and Pokemon itself
        $pokemonSlots = $this->pokemonSlotRepository->findByUser($userId);

        if(!$pokemonSlots){
            throw $this->createNotFoundException(
                "Pokemon slots for user $userId not found"
            );
        }

        Utils::logPerformance('user_dashboard', $this->stopwatch, $this->logger, $this->request);

        return $this->render('security/user_dashboard.html.twig', [
            'controller_name' => 'SecurityController',
            'user' => $user,
            'pokemonSlots' => $pokemonSlots
        ]);
    }

    /**
     * @Route("/user/profile", name="user_profile")
     */
    public function userProfile($userId)
    {
        $this->stopwatch->start('user_profile');

        // get user info
        $user = $this->userRepository->find($userId);

        if(!$user){
            throw $this->createNotFoundException(
                "User of id $userId not found"
            );
        }

        Utils::logPerformance('user_profile', $this->stopwatch, $this->logger, $this->request);

        return $this->render('security/user_profile.html.twig', [
            'controller_name' => 'SecurityController',
            'user' => $user,
        ]);
    }
}

