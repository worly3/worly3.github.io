<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * login
     *
     * @return void
     */
    public function login()
    {
    //   echo "<pre>";
    //   print_r(session()->all());die;
        return view("login");
    }
    /**
     * logged
     *
     * @param  mixed $request
     * @return void
     */
    public function logged(Request $request)
    {
    //           echo "<pre>";
    //   print_r(session()->all());die;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            "password" => 'required|min:6',
        ], [
            'email.required' => 'Email est obligatoire.',
            'email.email' => 'Email doit être valide.',
            'password.min' => 'Mot de Passe doit être au moins 6 caractères.',
            'password.required' => 'Mot de Passe est obligatoire.'
        ]);
        if ($validator->fails()) {
            return redirect()->route("login")
                ->withErrors($validator);
        }
        $email = $request->input("email");
        $user = DB::select("SELECT * from users where email = :email", ["email" => $email]);
        if (!empty($user)) {
            $user = $user[0];
            if (Hash::check($request->input("password"), $user->password)) {
                if($user->statut == "inactif"){
                Session::flash("fail", "Ce compte n'est pas actif.");
                return redirect()->route("login");    
                }
                Session::put("userlogged", $user->name);
                Session::put("userid", $user->id);
                Session::put("usertype", $user->type);
                Session::put("currentuser", $user);
                if ($user->type == 'admin' || $user->type == 'super') {
                    Session::put("skkadmin", $user->name);
                    return redirect()->route("adminaccueil");
                } else {
                    return redirect()->route("clientportal");
                }
                
            } else {
                Session::flash("fail", "Email ou Mot de Passe Invalide.");
                return redirect()->route("login");
            }
        } else {
            Session::flash("fail", "Email ou Mot de Passe Invalide.");
            return redirect()->route("login");
        }
    }
    /**
     * adLogout
     *
     * @return void
     */
    public function adLogout()
    {
        Session::remove("skkadmin");
        Session::remove("userlogged");
        Session::remove("userid");
        Session::remove("usertype");
        Session::remove("currentuser");
        return redirect()->route("login");
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        Session::remove("skkadmin");
        Session::remove("userlogged");
        Session::remove("userid");
        Session::remove("usertype");
        Session::remove("currentuser");
        Session::flash("success", "Reconnectez vous.");
        return redirect()->route("login");
    }
}
