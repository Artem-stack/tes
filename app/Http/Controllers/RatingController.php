<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use GuzzleHttp\Client;

class RatingController extends Controller
{
     public function store(Request $request)
{
    $ratingValue = $request->input('rating');

    if ($ratingValue === null || $ratingValue === '') {
        return redirect()->back()->with('error', 'Rating not specified');
    }

    $rating = new Rating;
    $rating->rating = $ratingValue;
    $rating->movie_id = $request->movie_id;
    $rating->save();

    return redirect()->back()->with('success', 'Rating added successfully');
}


    public function show($language)
{
    $movies = $this->getMoviesByLanguage($language);
    $ratings = $this->getRatingsForMovies($movies);

    return view('show', ['language' => $language, 'movies' => $movies, 'ratings' => $ratings]);
}

public function update(Request $request, $id)
{
    $ratingValue = $request->input('rating');

    if ($ratingValue === null || $ratingValue === '') {
        return redirect()->back()->with('error', 'Rating not specified');
    }

    $rating = Rating::where('movie_id', $id)->first();

    if (!$rating) {
        return redirect()->back()->with('error', 'Rating not found');
    }

    $rating->rating = $ratingValue;
    $rating->save();

    return redirect()->back()->with('success', 'Rating successfully changed');
}


private function getMoviesByLanguage($language)
{
    $client = new Client();
    $movies = [];

    $numPages = 3;

    for ($page = 1; $page <= $numPages; $page++) {
        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/now_playing', [
            'query' => [
                'language' => $language,
                'page' => $page,
                'api_key' => '05381bc6da4995c58136baae69e59dd7',
            ],
            'headers' => [
                'accept' => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        foreach ($data['results'] as $movie) {
            $movies[] = [
                'id' => $movie['id'], 
                'title' => $movie['title'],
            ];
        }
    }

    return $movies;
}


private function getRatingsForMovies($movies)
{
    $movieIds = array_column($movies, 'id');
    $ratings = Rating::whereIn('movie_id', $movieIds)->get();
    
    $ratingsByMovieId = [];

    foreach ($ratings as $rating) {
        $ratingsByMovieId[$rating->movie_id] = $rating->rating;
    }

    return $ratingsByMovieId;
	}

	public function destroy($id)
{
   
    Rating::where('movie_id', $id)->delete();
    
    return redirect()->back()->with('success', 'Rating deleted successfully');
}

}
