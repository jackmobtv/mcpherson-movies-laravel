<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DAO\MovieDAO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    public function Movies() : Response
    {
        $Attributes = [];

        $movies = MovieDAO::GetAllMovies();

        $serializedMovies = [];

        foreach ($movies as $movie) {
            $serializedMovies[] = $movie->jsonSerialize();
        }

        $Attributes['moviesJSON'] = json_encode($serializedMovies);

        return Inertia::render('movies/movies', $Attributes);
    }
}
