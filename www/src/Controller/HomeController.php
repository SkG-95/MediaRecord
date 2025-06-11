<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TmdbApiManager;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TmdbApiManager $tmdbApiService): Response
    {
        $popularMovies = $tmdbApiService->getPopularMovies();
        $upcomingMovies = $tmdbApiService->getUpcoming(); // Retourne un tableau de films
        $topratedMovies = $tmdbApiService->getTopRatedMovies(); // Retourne un tableau de films

        return $this->render('home/index.html.twig', [
            'popular_movies' => $popularMovies,
            'upcoming_movies' => $upcomingMovies,
            'toprated_movies' => $topratedMovies,
        ]);
    }
}
