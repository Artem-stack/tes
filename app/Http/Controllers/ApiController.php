<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
      public function fetchData()
      {
 $client = new Client();
        $languages = [];

        $numPages = 3;

        for ($page = 1; $page <= $numPages; $page++) {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/now_playing', [
                'query' => [
                    'language' => 'en-US',
                    'page' => $page,
                    'api_key' => '05381bc6da4995c58136baae69e59dd7',
                ],
                'headers' => [
                    'accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            foreach ($data['results'] as $movie) {
                if (isset($movie['original_language']) && !in_array($movie['original_language'], $languages)) {
                    $languages[] = $movie['original_language'];
                }
            }
        }

        return view('index', ['languages' => $languages]);
    }
}
