<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DAO\MovieDAO;
use App\Models\shared\OMDB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function View_Movie(Request $request) : Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser")->jsonSerialize() : null;

        $movie = MovieDAO::GetMovieById(intval($request->query('id')));
        $movie->jsonSerialize();

        $movieData = OMDB::GetMovieData($movie->getTitle());

        $Attributes['userJSON'] = json_encode($user);
        $Attributes['movieJSON'] = json_encode($movie);
        $Attributes['poster'] = $movieData['poster'];
        $Attributes['plot'] = $movieData['plot'];

        return Inertia::render('movies/view_movie', $Attributes);
    }
}
