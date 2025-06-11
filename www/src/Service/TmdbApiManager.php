<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TmdbApiManager
{
    private $client;
    private $apiKey;
    private $authHeader;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->authHeader = 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI0OTBjNWVmMDYzNzE5NzEzMDhhZGMwYWFlYjU3OTc4NiIsIm5iZiI6MTc0NDc5NzE2My4zMywic3ViIjoiNjdmZjdkZWI4M2M2ZTU2N2M3ZDkyZGM4Iiwic2NvcGVzIjpbImFwaV9yZWFkIl0sInZlcnNpb24iOjF9.53ON0XM-zX8BuydYClUmLTNpjHRNtzeesBD8T-fVnrs';
    }

    private function makeRequest(string $url): array
    {
        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => $this->authHeader,
                'accept' => 'application/json',
            ],
        ]);

        return $response->toArray();
    }

    public function getApiCall(): array
    {
        $data = $this->makeRequest('https://api.themoviedb.org/3/authentication');
        return $data['results'] ?? [];
    }

    public function getUpcoming(): array
    {
        $data = $this->makeRequest('https://api.themoviedb.org/3/movie/upcoming?language=fr&page=1');
        return $data['results'] ?? [];
    }

    public function getPopularMovies(): array
    {
        $data = $this->makeRequest('https://api.themoviedb.org/3/movie/popular?language=fr&page=1');
        return $data['results'] ?? [];
    }

    public function getSearchmovie(string $query): array
    {
        $encodedQuery = urlencode($query);
        $data = $this->makeRequest("https://api.themoviedb.org/3/search/movie?query={$encodedQuery}&include_adult=false&language=fr&page=1");
        return $data['results'] ?? [];
    }

    // Nouvelle méthode pour récupérer les détails complets d'un film
    public function getMovieDetails(int $tmdbId): array
    {
        return $this->makeRequest("https://api.themoviedb.org/3/movie/{$tmdbId}?language=fr");
    }

        public function getTopRatedMovies(): array
    {
        $data = $this->makeRequest('https://api.themoviedb.org/3/movie/top_rated?language=fr&page=1');
        return $data['results'] ?? [];
    }

    public function getNowPlayingMovies(): array
    {
        $data = $this->makeRequest('https://api.themoviedb.org/3/movie/now_playing?language=fr&page=1');
        return $data['results'] ?? [];
    }
}
