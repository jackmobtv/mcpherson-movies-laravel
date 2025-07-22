<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DAO\MovieDAO;
use App\Models\shared\OMDB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function Home() : Response
    {
        $Attributes = [];

        $movie = MovieDAO::GetRandomMovie();
        $movieData = OMDB::GetMovieData($movie->title);

        $Attributes['id'] = $movie->movie_id;
        $Attributes['title'] = $movie->title;
        $Attributes['poster'] = $movieData['poster'];
        $Attributes['plot'] = $movieData['plot'];

        return Inertia::render('home', $Attributes);
    }
}
