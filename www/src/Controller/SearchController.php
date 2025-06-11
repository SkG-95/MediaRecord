<?php
// src/Controller/SearchController.php
namespace App\Controller;

use App\Form\MovieSearchType;
use App\Entity\Media;
use App\Service\TmdbApiManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\Exception\ClientException;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(
        Request $request,
        TmdbApiManager $tmdbApiService,
        EntityManagerInterface $em
    ): Response
    {
        $form = $this->createForm(MovieSearchType::class);
        $form->handleRequest($request);

        $movies = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('query')->getData();
            
            try {
                // Récupère les résultats de recherche
                $searchResults = $tmdbApiService->getSearchmovie($query);
                
                foreach ($searchResults as $movieData) {
                    // Récupère les détails complets du film
                    $fullDetails = $tmdbApiService->getMovieDetails($movieData['id']);
                    
                    $existing = $em->getRepository(Media::class)->findOneBy(['tmdbId' => $fullDetails['id']]);
                    
                    if (!$existing) {
                        $media = $this->createMediaFromApiData($fullDetails);
                        $em->persist($media);
                        $movies[] = $media;
                    } else {
                        $movies[] = $existing;
                    }
                }
                $em->flush();
                
            } catch (ClientException $e) {
                $this->addFlash('error', 'Erreur API : '.$e->getMessage());
            }
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'movies' => $movies,
        ]);
    }

    private function createMediaFromApiData(array $data): Media
    {
        $media = new Media();
        
        // Hydratation de toutes les propriétés
        $media->setTmdbId($data['id'])
            ->setAdult($data['adult'] ?? false)
            ->setBackdropPath($data['backdrop_path'])
            ->setGenreIds($data['genre_ids'] ?? [])
            ->setOriginalLanguage($data['original_language'])
            ->setOriginalTitle($data['original_title'])
            ->setOverview($data['overview'])
            ->setPopularity($data['popularity'])
            ->setPosterPath($data['poster_path'])
            ->setReleaseDate(new \DateTime($data['release_date'] ?? 'now'))
            ->setTitle($data['title'])
            ->setVideo($data['video'] ?? false)
            ->setVoteAverage($data['vote_average'])
            ->setVoteCount($data['vote_count']);

        return $media;
    }
}
