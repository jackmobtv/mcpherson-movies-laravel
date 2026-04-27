<?php

namespace App\Http\Controllers;

use App\Models\DAO\FavoriteDAO;
use App\Models\DAO\UserDAO;
use App\Models\Favorite;
use App\Models\shared\Validators;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Mockery\Exception;

class UserController extends Controller
{
    public function SignUp_Get() : Response
    {
        return Inertia::render('users/signup');
    }

    public function SignUp_Post() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $errorFound = false;

        if(!Validators::isValidEmail(request('email'))){
            $errorFound = true;
            $Attributes['email'] = request('email');
            $Attributes['emailError'] = "Invalid Email";
        }

        if(!Validators::isStrongPassword(request('password'))){
            $errorFound = true;
            $Attributes['password'] = request('password');
            $Attributes['password1Error'] = "Password must between 7 and 20 characters long";
        }

        if(request('password') != request('password-conf')){
            $errorFound = true;
            $Attributes['password'] = request('password');
            $Attributes['passwordConf'] = request('password-conf');
            $Attributes['password2Error'] = "Passwords Do Not Match";
        }

        if($errorFound){
            return Inertia::render('users/signup', $Attributes);
        }

        $success = UserDAO::addUser(request('email'), request('password'), request('dob'));

        if($success){
            session()->put('flashMessageDanger', "Failed to Add User");
            return Inertia::render('users/signup');
        }

        session()->put('flashMessageSuccess', "User Successfully Created, Please Login");
        return redirect("/login");
    }

    public function Login_Get() : Response
    {
        return Inertia::render('users/login');
    }

    public function Login_Post() : RedirectResponse | Redirector | Response
    {
        $user = UserDAO::auth(request('email'), request('password'));

        if($user == null){
            session()->put('flashMessageDanger', "Invalid Email or Password");
            return redirect("/login");
        }

        session()->invalidate();
        session()->put('currentUser', $user);
        session()->put('flashMessageSuccess', "Login Successful");

        return redirect("/");
    }

    public function Logout() : RedirectResponse | Redirector | Response
    {
        session()->invalidate();
        session()->put('flashMessageSuccess', "Logout Successful");
        return redirect("/");
    }

    public function Favorites() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active") {
            $favorites = FavoriteDAO::GetFavoriteMovies($user->getUserId());

            $Attributes['favoritesJSON'] = json_encode($favorites);

            return Inertia::render('favorites/favorites', $Attributes);
        } else {
            session()->put('flashMessageWarning', "You Must Be Logged In to Access this Page");
            return redirect('/login');
        }
    }

    public function User_Favorites(Request $request) : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $id = intval($request->query('id'));

        $user = UserDAO::get($id);
        $Attributes['userJSON'] = json_encode($user);

        $favorites = Favorite::SerializeArray(FavoriteDAO::GetFavoriteMovies($id));
        $Attributes['favoritesJSON'] = json_encode($favorites);

        return Inertia::render('favorites/user_favorites', $Attributes);
    }

    public function Users() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            $users = UserDAO::getAll();
            $Attributes['usersJSON'] = json_encode($users);
            return Inertia::render('users/admin_users', $Attributes);
        } else {
            session()->put('flashMessageDanger', "You must be an Admin to Access this Page");
            return redirect("/");
        }
    }

    public function View_Profile(Request $request) : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = UserDAO::get(intval($request->query('id')));
        $Attributes['userJSON'] = json_encode($user);

        return Inertia::render('users/view_profile', $Attributes);
    }

    public function Edit_Profile_Get() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null) {
            $Attributes['userJSON'] = json_encode($user);
            return Inertia::render('users/edit_profile', $Attributes);
        } else {
            session()->put('flashMessageDanger', "You must be Logged in to Access this Page");
            return redirect("/login");
        }
    }

    public function Edit_Profile_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null) {
            $userUpdate = new User();
            $userUpdate->setUserId($user->getUserId());
            $userUpdate->setFirstName($request->post('firstName'));
            $userUpdate->setLastName($request->post('lastName'));
            $userUpdate->setEmail($request->post('email'));
            $userUpdate->setPhone($request->post('phone'));
            $userUpdate->setLanguage($request->post('language'));
            $userUpdate->setPronouns($request->post('pronouns'));
            $userUpdate->setDescription($request->post('description'));
            $userUpdate->setTimezone("America/Chicago");

            try{
                if($userUpdate->getEmail() == null || (UserDAO::getByEmail($userUpdate->getEmail()) != null && $userUpdate->getEmail() != $user->getEmail())) throw new Exception("Invalid Email");
                if(!Validators::isValidPhone($userUpdate->getPhone())) throw new Exception("Invalid Phone Number");

                UserDAO::update($userUpdate);
            } catch (Exception){
                session()->put('flashMessageDanger', "Failed to Update Profile");
                return redirect("/edit-profile");
            }

            session()->invalidate();
            session()->put('currentUser', UserDAO::get($userUpdate->getUserId()));

            session()->put('flashMessageSuccess', "Account Updated");
            return redirect("/");
        } else {
            session()->put('flashMessageDanger', "You must be Logged in to Access this Page");
            return redirect("/login");
        }
    }

    public function Deactivate_User_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user != null && $user->getStatus() == "active" && $user->getPrivileges() == "Admin") {
            try {
                $id = intval($request->post('id'));

                $userCheck = UserDAO::get($id);
                if($userCheck == null){
                    throw new Exception("User Not Found");
                }

                if($userCheck->getStatus() == "active"){
                    UserDAO::deactivate($id);
                } else {
                    UserDAO::activate($id);
                }
            } catch (Exception){
                session()->put('flashMessageDanger', "Action Failed");
                return redirect("/users");
            }
            return redirect("/users");
        } else {
            session()->put('flashMessageDanger', "You must be an Admin to Access this Function");
            return redirect("/");
        }
    }

    public function Delete_Account_Get() : RedirectResponse | Redirector | Response
    {
        $Attributes = [];

        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;

        if($user == null) {
            session()->put('flashMessageWarning', "You Must Be Logged In");
            return redirect("/login");
        } else if ($user->getStatus() != "active") {
            session()->put('flashMessageDanger', "Your Account is Locked or Inactive");
            return redirect("/");
        }

        return Inertia::render('users/delete_account', $Attributes);
    }

    public function Delete_Account_Post(Request $request) : RedirectResponse | Redirector | Response
    {
        $user = session()->get("currentUser") != null ? session()->get("currentUser") : null;
        $email = $request->post('email');
        $password = $request->post('password');

        try {
            if($user->getEmail() != $email || !UserDAO::delete($user->getEmail(), $password)) throw new Exception("Invalid Credentials");
        } catch (Exception){
            session()->put('flashMessageDanger', "Invalid Email or Password");
            return redirect("/delete-account");
        }

        session()->invalidate();
        session()->put('flashMessageSuccess', "Account Successfully Deleted");

        return redirect("/");
    }
}
