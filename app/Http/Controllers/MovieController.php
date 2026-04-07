<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DAO\ActorDAO;
use App\Models\DAO\MovieDAO;
use App\Models\Movie;
use App\Models\shared\OMDB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    public function Movies() : Response
    {
        $Attributes = [];

        $movies = MovieDAO::GetAllMovies();

        $movies = Movie::SerializeArray($movies);

        $Attributes['moviesJSON'] = json_encode($movies);

        return Inertia::render('movies/movies', $Attributes);
    }

    public function View_Movie(Request $request) : Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser")->jsonSerialize() : null;

        $movie = MovieDAO::GetMovieById(intval($request->query('id')));
        $movie->jsonSerialize();

        $movieData = OMDB::GetMovieData($movie->getTitle());

        $actors = ActorDAO::GetActorsByMovieId($movie->getMovieId());

        $Attributes['userJSON'] = json_encode($user);
        $Attributes['movieJSON'] = json_encode($movie);
        $Attributes['actorsJSON'] = json_encode($actors);
        $Attributes['poster'] = $movieData['poster'];
        $Attributes['plot'] = $movieData['plot'];

        return Inertia::render('movies/view_movie', $Attributes);
    }

    public function Update_Movie_Get(Request $request) : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getPrivileges() == "Admin") {
            $movie = MovieDAO::GetMovieTableById(intval($request->query('id')));
            $movie->jsonSerialize();

            $actors = ActorDAO::GetActorsByMovieId($movie->getMovieId());
            $formats = MovieDAO::GetAllFormats();
            $locations = MovieDAO::GetAllLocations();

            $Attributes['movieJSON'] = json_encode($movie);
            $Attributes['actorsJSON'] = json_encode($actors);
            $Attributes['formatsJSON'] = json_encode($formats);
            $Attributes['locationsJSON'] = json_encode($locations);

            return Inertia::render('movies/update_movie', $Attributes);
        } else {
            session()->put('flashMessageWarning', "You Must Be an Admin to Access this Page");
            return redirect('/');
        }
    }

    public function Update_Movie_Post() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getPrivileges() == "Admin") {
            $validator = Validator::make(request()->all(), [
                'title' => ['required', 'min:1', 'max:255'],
                'genre' => ['required', 'min:1', 'max:255'],
                'sub_genre' => 'max:255',
                'locationId' => ['required', 'min:1'],
                'formatId' => ['required', 'min:1']
            ]);

            if ($validator->fails() || (intval(request()->input('release_year')) !== null && intval(request()->input('release_year') < 1900))) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $movie = new Movie();
            $errors = null;

            $movie->setMovieId(request()->input('movie_id'));
            $movie->setTitle(request()->input('title'));
            $movie->setGenre(request()->input('genre'));
            $movie->setSubGenre(request()->input('sub_genre'));
            $movie->setReleaseYear(request()->input('release_year'));
            $movie->setLocationId(request()->input('locationId'));
            $movie->setFormatId(request()->input('formatId'));

            $errors = MovieDAO::UpdateMovie($movie) ? null : "Update Failed";

            if($errors != null) {
                return redirect()->back()->with('error', $errors);
            }

            session()->put('flashMessageSuccess', "Movie Updated");
            return redirect("/view-movie?id={$movie->getMovieId()}");
        } else {
            session()->put('flashMessageWarning', "You Must Be an Admin to Access this Page");
            return redirect('/');
        }
    }

    public function Delete_Movie_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $movie_id = intval($request->post('id'));

            $success = false;
            $success = MovieDAO::DeleteMovie($movie_id);

            if($success) {
                session()->put('flashMessageSuccess', "Movie Deleted");
            } else {
                session()->put('flashMessageDanger', "Failed to Delete Movie");
            }

            return redirect("/movies");
        } else {
            session()->put('flashMessageWarning', "Session Expired");
            return redirect('/login');
        }
    }

    public function Add_Movie_Get() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $formats = MovieDAO::GetAllFormats();
            $locations = MovieDAO::GetAllLocations();

            $Attributes['formatsJSON'] = json_encode($formats);
            $Attributes['locationsJSON'] = json_encode($locations);

            return Inertia::render('movies/add_movie', $Attributes);
        } else {
            session()->put('flashMessageWarning', "You Must Be an Admin to Access this Page");
            return redirect('/');
        }
    }

    public function Add_Movie_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $validator = Validator::make(request()->all(), [
                'title' => ['required', 'min:1', 'max:255'],
                'genre' => ['required', 'min:1', 'max:255'],
                'sub_genre' => 'max:255',
                'locationId' => ['required', 'min:1'],
                'formatId' => ['required', 'min:1']
            ]);

            if ($validator->fails() || (intval(request()->input('release_year')) !== null && intval(request()->input('release_year') < 1900))) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $movie = new Movie();
            $errors = null;

            $movie->setMovieId(MovieDAO::GetLastID() + 1);
            $movie->setTitle(request()->input('title'));
            $movie->setGenre(request()->input('genre'));
            $movie->setSubGenre(request()->input('sub_genre'));
            $movie->setReleaseYear(request()->input('release_year'));
            $movie->setLocationId(request()->input('locationId'));
            $movie->setFormatId(request()->input('formatId'));

            $errors = MovieDAO::AddMovie($movie) ? null : "Insert Failed";

            if($errors != null) {
                return redirect()->back()->with('error', $errors);
            }

            session()->put('flashMessageSuccess', "Movie Added");
            return redirect("/view-movie?id={$movie->getMovieId()}");
        } else {
            session()->put('flashMessageWarning', "Session Expired");
            return redirect('/login');
        }
    }
}
