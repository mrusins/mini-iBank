<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class Register extends Controller
{
    public function register(){

       $user = new User(
           [
               'name' => $_POST['name'],
               'email' => $_POST['email'],
               'password'=>$_POST['password']
           ]

       );
       $user->save();
        var_dump($user);
    }
}
