<?php
// src/Controller/ImportController.php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Genre;
use App\Entity\MediaGenre;
use App\Service\TmdbApiManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    #[Route('/admin/import/movies', name: 'app_import_movies')]
    public function importMovies(TmdbApiManager $tmdbApiManager, EntityManagerInterface $entityManager): Response
    {
        // Récupérer les films populaires
        $popularMovies = $tmdbApiManager->getApiCall();
        
        foreach ($popularMovies['results'] as $movieData) {
            // Vérifier si le film existe déjà
            $existingMedia = $entityManager->getRepository(Media::class)->findOneBy([
                'tmdb_id' => $movieData['id']
            ]);
            
            if (!$existingMedia) {
                // Créer un nouveau média
                $media = new Media();
                $media->setTmdbId($movieData['id']);
                $media->setTitle($movieData['title']);
                $media->setMediaType('movie');
                $media->setReleaseDate(new \DateTime($movieData['release_date']));
                $media->setPosterPath($movieData['poster_path']);
                $media->setOverview($movieData['overview']);
                $media->setVoteAverage($movieData['vote_average']);
                
                // Ajouter les genres
                foreach ($movieData['genre_ids'] as $genreId) {
                    $genre = $entityManager->getRepository(Genre::class)->findOneBy(['id' => $genreId]);
                    
                    if (!$genre) {
                        // Si le genre n'existe pas, vous devriez d'abord importer tous les genres
                        continue;
                    }
                    
                    $mediaGenre = new MediaGenre();
                    $mediaGenre->setMedia($media);
                    $mediaGenre->setGenre($genre);
                    $entityManager->persist($mediaGenre);
                }
                
                $entityManager->persist($media);
            }
        }
        
        $entityManager->flush();
        
        return $this->render('import/success.html.twig', [
            'count' => count($popularMovies['results'])
        ]);
    }

    #[Route('/admin/import/genres', name: 'app_import_genres')]
    public function importGenres(TmdbApiManager $tmdbApiManager, EntityManagerInterface $entityManager): Response
    {
    // Ajouter une méthode getGenres() à votre service TmdbApiService
    $genres = $tmdbApiManager->getGenres();
    
    foreach ($genres['genres'] as $genreData) {
        $existingGenre = $entityManager->getRepository(Genre::class)->findOneBy([
            'id' => $genreData['id']
        ]);
        
        if (!$existingGenre) {
            $genre = new Genre();
            $genre->setId($genreData['id']);
            $genre->setName($genreData['name']);
            
            $entityManager->persist($genre);
        }
    }
    
    $entityManager->flush();
    
    return $this->render('import/success.html.twig', [
        'count' => count($genres['genres'])
    ]);
}

}
