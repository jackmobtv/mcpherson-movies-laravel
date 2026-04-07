<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\DAO\ActorDAO;
use App\Models\DAO\MovieDAO;
use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ActorController
{
    public function Actors() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && ($user->getPrivileges() == "Admin" || $user->getPrivileges() == "Premium")) {
            $actors = ActorDAO::GetAllActors();

            $actors = Actor::SerializeArray($actors);

            $user = $user->jsonSerialize();

            $Attributes['userJSON'] = json_encode($user);
            $Attributes['actorsJSON'] = json_encode($actors);

            return Inertia::render('actors/actors', $Attributes);
        } else {
            session()->put('flashMessageWarning', "Page is Restricted to Premium Users");
            // TODO add pricing page
            return redirect('/');
        }
    }

    public function View_Actor(Request $request) : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && ($user->getPrivileges() == "Admin" || $user->getPrivileges() == "Premium")) {
            $actor = ActorDAO::GetActorById(intval($request->query('id')));

            $movies = MovieDAO::GetMoviesByActorID($actor->getActorId());
            $movies = Movie::SerializeArray($movies);

            $user = $user->jsonSerialize();

            $Attributes['userJSON'] = json_encode($user);
            $Attributes['actorJSON'] = json_encode($actor);
            $Attributes['moviesJSON'] = json_encode($movies);

            return Inertia::render('actors/view_actor', $Attributes);
        } else {
            session()->put('flashMessageWarning', "Page is Restricted to Premium Users");
            // TODO add pricing page
            return redirect('/');
        }
    }

    public function Update_Actor_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $name = $request->post('name');
        $id = intval($request->post('id'));

        $success = false;
        $success = ActorDAO::UpdateActor($id, $name);

        if($success) {
            session()->put('flashMessageSuccess', "Actor Successfully Updated");
        } else {
            session()->put('flashMessageDanger', "Actor Could Not Be Updated");
        }

        return redirect('/actors');
    }

    public function Add_Actor_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $id = intval($request->post('id'));
            $name = $request->post('name');
            $success = false;

            $success = ActorDAO::AddActor($id, $name);

            if($success) {
                session()->put('flashMessageSuccess', "Actor Successfully Added");
                return redirect("/view-movie?id=" . $id);
            } else {
                session()->put('flashMessageDanger', "Failed to Add Actor");
                return redirect()->back();
            }
        } else {
            session()->put('flashMessageWarning', "Session Expired");
            return redirect('/login');
        }
    }

    public function Remove_Movie_Actor_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $actor_id = intval($request->input('actor_id'));
            $movie_id = intval($request->input('movie_id'));

            $success = false;
            $success = ActorDAO::DeleteMovieActor($movie_id, $actor_id);

            if($success) {
                session()->put('flashMessageSuccess', "Actor Removed");
            } else {
                session()->put('flashMessageDanger', "Failed to Remove Actor");
            }

            return redirect("/view-movie?id=" . $movie_id);
        } else {
            session()->put('flashMessageWarning', "Session Expired");
            return redirect('/login');
        }
    }

    public function Remove_Actor_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $actor_id = intval($request->input('id'));

            $success = false;
            $success = ActorDAO::DeleteActor($actor_id);

            if($success) {
                session()->put('flashMessageSuccess', "Actor Removed");
            } else {
                session()->put('flashMessageDanger', "Failed to Remove Actor");
            }

            return redirect("/actors");
        } else {
            session()->put('flashMessageWarning', "Session Expired");
            return redirect('/login');
        }
    }
}
