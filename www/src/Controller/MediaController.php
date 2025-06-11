<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\TmdbApiManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Media;

final class MediaController extends AbstractController
{
    #[Route('/media', name: 'app_media')]
    public function list(TmdbApiManager $tmdbApiManager): Response
    {
        $authentificator = $tmdbApiManager->getApiCall();
        // Récupérer les films populaires
        $popularMovies = $tmdbApiManager->getUpcoming();

        return $this->render('media/index.html.twig', [
            'popularMovies' => $popularMovies,
            'authentificator' => $authentificator,
        ]);
    }

    #[Route('/movie/{tmdbId}', name: 'movie_show', requirements: ['tmdbId' => '\d+'])]
public function show(
    int $tmdbId, 
    TmdbApiManager $tmdbApiManager,
    EntityManagerInterface $em
): Response {
    $media = $em->getRepository(Media::class)->findOneBy(['tmdbId' => $tmdbId]);

    if (!$media) {
        $movieData = $tmdbApiManager->getMovieDetails($tmdbId);

        if (empty($movieData)) {
            throw $this->createNotFoundException('Film non trouvé');
        }

        // Ajout de la gestion du champ 'video'
        $media = new Media();
        $media->setTmdbId($movieData['id']);
        $media->setTitle($movieData['title'] ?? 'Titre inconnu');
        $media->setOriginalTitle($movieData['original_title'] ?? $media->getTitle());
        $media->setOriginalLanguage($movieData['original_language'] ?? 'en');
        $media->setOverview($movieData['overview'] ?? '');
        $media->setPosterPath($movieData['poster_path'] ?? '');
        $media->setReleaseDate(
            !empty($movieData['release_date']) ? 
            new \DateTime($movieData['release_date']) : 
            new \DateTime('1970-01-01')
        );
        $media->setVoteAverage($movieData['vote_average'] ?? 0.0);
        $media->setVoteCount($movieData['vote_count'] ?? 0);
        $media->setPopularity($movieData['popularity'] ?? 0.0);
        $media->setVideo($movieData['video'] ?? false); // <-- Ligne cruciale ajoutée

        $em->persist($media);
        $em->flush();
    }

    return $this->render('media/show.html.twig', [
        'movie' => $media,
    ]);
}

    #[Route('/films/a-venir', name: 'app_upcoming')]
    public function upcoming(TmdbApiManager $tmdbApiManager): Response
    {
        // Récupère les films à venir depuis TMDB
        $upcomingMovies = $tmdbApiManager->getUpcoming();

        return $this->render('media/upcoming.html.twig', [
            'movies' => $upcomingMovies,
        ]);
    }

    #[Route('/films/populaires', name: 'app_popular')]
    public function popular(TmdbApiManager $tmdbApiManager): Response
    {
        // Récupère les films à venir depuis TMDB
        $popularMovies = $tmdbApiManager->getPopularMovies();

        return $this->render('media/popular.html.twig', [
            'movies' => $popularMovies,
        ]);
    }

    #[Route('/films/mieux-notes', name: 'app_top_rated')]
    public function topRated(TmdbApiManager $tmdbApiManager): Response
    {
        $topRatedMovies = $tmdbApiManager->getTopRatedMovies();

        return $this->render('media/top_rated.html.twig', [
            'movies' => $topRatedMovies,
        ]);
    }
}
