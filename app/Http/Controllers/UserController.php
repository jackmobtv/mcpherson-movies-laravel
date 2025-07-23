<?php

namespace App\Http\Controllers;

use App\Models\DAO\UserDAO;
use App\Models\shared\Validators;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

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
            $Attributes['password1Error'] = "Invalid Password";
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
}
