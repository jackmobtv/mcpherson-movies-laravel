<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function SignUp() : Response
    {
        $Attributes = [];

        return Inertia::render('sign-up', $Attributes);
    }

    public function SignUp_Post() : Response
    {
        $Attributes = [];

        return Inertia::render('', $Attributes);
    }
}
