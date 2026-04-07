<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DAO\MovieDAO;
use App\Models\DAO\UserDAO;
use App\Models\shared\OMDB;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function Home() : Response
    {
        $Attributes = [];

        $movie = MovieDAO::GetRandomMovie();
        $movieData = OMDB::GetMovieData($movie->getTitle());

        $Attributes['id'] = $movie->getMovieId();
        $Attributes['title'] = $movie->getTitle();
        $Attributes['poster'] = $movieData['poster'];
        $Attributes['plot'] = $movieData['plot'];

        return Inertia::render('home', $Attributes);
    }

    public function About() : RedirectResponse | Redirector | Response
    {
        return Inertia::render('about');
    }

    public function Terms() : RedirectResponse | Redirector | Response
    {
        return Inertia::render('terms');
    }

    public function Pricing_Get() : RedirectResponse | Redirector | Response
    {
        return Inertia::render('pricing');
    }

    public function Pricing_Post() : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user == null) {
            session()->put('flashMessageWarning', "You Must Be Logged in");
            return redirect('/login');
        } else if($user->getStatus() != "active") {
            session()->put('flashMessageWarning', "Account is Inactive");
            return redirect('/');
        } else if($user->getPrivileges() != "User") {
            session()->put('flashMessageWarning', "Your Account already has Access");
            return redirect('/');
        }

        $success = false;
        $success = UserDAO::upgrade($user->getUserId());

        if($success) {
            session()->put('flashMessageDanger', "User Upgraded, Please Log In");
            session()->invalidate();
        } else {
            session()->put('flashMessageSuccess', "Upgrade Failed");
        }

        return redirect('/');
    }
}
