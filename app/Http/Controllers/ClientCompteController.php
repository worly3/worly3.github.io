<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Str;
use Helper;

class ClientCompteController extends Controller
{
    public function creationCompte(){
        return view("creationcompte");
    }
    public function CreerCompte(Request $request){
      $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'prenom' => 'required|min:3',
            'adresse' => 'required|string|min:6',
            'tel' => 'required|numeric',
            'email' => 'required|unique:users,email|email:rfc,dns',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ], [
            'prenom.required' => 'Prénom est obligatoire.',
            'prenom.min' => 'Prénom doit être au moins 3 caractères.',
            'adresse.required' => 'Adresse est obligatoire.',
            'adresse.min' => 'Adresse doit être au moins 6 caractères.',
            'tel.required' => 'Numéro de téléphone est obligatoire.',
            'email.required' => 'Email est obligatoire.',
            'email.unique' => 'Email déja utilisé.',
            'username.required' => 'Pseudo est obligatoire.',
            'username.min' => 'Pseudo doit être au moins 3 caractères.',
            'email.email' => 'Email doit être valide.',
            'password.min' => 'Mot de Passe doit être au moins 6 caractères.',
            'password.required' => 'Mot de Passe est obligatoire.',
            'password_confirmation.min' => 'Mot de Passe et la confirmation doivent êtres identiques.',
            'password_confirmation.required' => 'La confirmation du Mot de Passe est obligatoire.',
            'password.confirmed' => 'Mot de Passe et la confirmation doivent êtres identiques.'
        ]);
        if ($validator->fails()) {
            return redirect()->route("creercompte")
                ->withErrors($validator);
        }  
        $user = new User();
        $email = $request->input("email");
        $token = str_replace(["/", "."], '', Hash::make(Str::random(16)));
        $user->name = $request->input("username");
        $user->prenom = $request->input("prenom");
        $user->tel = $request->input("tel");
        $user->map = $request->input("adresse");
        $user->email = $email;
        $user->statut = "inactif";
        $user->type = "client";
        $user->token = $token;
        $user->password = Hash::make($request->input("password"));
        $message = "Bienvenue sur WORLY votre Boutique en Ligne";
        
        $data = [
            "user" => $request->input("username"),
            "Title" => "Compte Activation",
            "Token" => $token,
            "Content" => $message
        ];
        if(Mail::send('mails.emailMessage', $data, function ($content) use ($email) {
                $content->to($email, 'WORLY')->subject("WORLY");
                $content->from('contact@worly.com', 'WORLY');
            })){
         
        if ($user->save()) {
                Session::flash("success", "Compte crée.\nVous allez recevoir un lien d'activation.\nVérifiez vos couriel indésirables");
            } else {
                Session::flash("fail", "Ouoops une erreur est suvernue.");
            }
        
        }else{
         Session::flash("fail", "Ouoops une erreur est suvernue lors de l'envoi du lien d'activation.");   
        }
        return redirect()->route('login');
    }
   
   public function ActiverCompte($token){
   $user = DB::select("SELECT * from users where token = :token", ["token" => $token]);

    if (!empty($user)) {
    $user = $user[0];
    $activacteUser = DB::update("UPDATE users SET statut = :statut, token =:token WHERE id =:id", 
    [
      'statut' => 'actif',
      'token' => null,
      'id' => $user->id,
    ]);
    if ($activacteUser > 0) {
        Session::flash("success", "Compte activé."); 
    } else {
        Session::flash("fail", "Lien Invalide."); 
    }
    
    } else {
        Session::flash("fail", "Lien Invalide."); 
    }
    return redirect()->route('login'); 
   }
   
   public function index() {
     return view("client.home");
    }
     
    public function mesCommandes(){
     $mescommandes = DB::select("SELECT * FROM commandes WHERE client =:id", 
    [
      'id' => Session::get("userid"),
    ]); 
     return view("client.mescommandes", compact("mescommandes"));
     }
    public function mesFavoris(){
        $favArticles = Helper::favArticles();
        $idsArticles =[];
        foreach($favArticles as $item){
        array_push($idsArticles, $item->id);    
        }
        
        return  view("client.mesfavoris",compact("idsArticles", "favArticles"));
    }  
    
    public function delMonFav($id){
    Session::remove('favArticle'.$id);
    $favArticles = Helper::favArticles();
    if(count($favArticles) > 0){
        Session::flash("success", "Favoris supprimer");
    }else{
        Session::flash("fail", "vous n'avez plus d'article Favoris"); 
    }  
    return redirect()->route("mesfavoris");
    }
    
    public function monPanier(){
    $panierArticles = Helper::panierArticles();
        $idsArticles =[];
        
        foreach($panierArticles as $item){
        array_push($idsArticles, $item->id);    
        }
        return view("client.monpanier", compact("idsArticles","panierArticles"));
    }
    public function voireMaCommande($id){
    $commande = DB::table('commandes')->find($id);
    $montant = Helper::commandeMontantTotal($commande->articles,$commande->qtyarticles);
    if(!empty($commande)){
    return view("client.voirecommande",compact("commande", "montant"));
    }else{
    Session::flash("fail", "Ouoops une erreur est suvernue."); 
    return redirect()->route("clientportal");    
    } 
        
    }
    
    public function mesDonnees(){
        return view("client.mesdonnees");
    }
    
    public function updateMesDonnees(Request $request){
    $data = Session::get("currentuser");
    if(!$data || $data->id != $request->id){
        return redirect()->route("logout");
    }
       $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'prenom' => 'required|min:3',
            'adresse' => 'required|string|min:6',
            'tel' => 'required|numeric',
             'email' => [
                'required','email:rfc,dns',
                Rule::unique('users')->ignore($data->id),
            ],
        ], [
            'prenom.required' => 'Prénom est obligatoire.',
            'prenom.min' => 'Prénom doit être au moins 3 caractères.',
            'adresse.required' => 'Adresse est obligatoire.',
            'adresse.min' => 'Adresse doit être au moins 6 caractères.',
            'tel.required' => 'Numéro de téléphone est obligatoire.',
            'email.required' => 'Email est obligatoire.',
            'email.unique' => 'Email déja utilisé.',
            'username.required' => 'Pseudo est obligatoire.',
            'username.min' => 'Pseudo doit être au moins 3 caractères.',
            'email.email' => 'Email doit être valide.',
        ]);
        if ($validator->fails()) {
            return redirect()->route("mesdonnees")
                ->withErrors($validator);
        } 
         $moncompte =  DB::table('users')->where('id',$request->id)->update([
            "name" => $request->input('username'),
            "prenom" => $request->prenom,
            "tel" => $request->tel,
            "map" => $request->adresse,
        ]);
        if ($moncompte > 0) {
            Session::flash("success", "Informations modifier avec succes.");
        } else {
            Session::flash("fail", "Désolé une erreur s'est produite.");
        }
        return redirect()->route("logout");
    }
    public function codeOublier(){
        return view("codeoublier");
    }
    
    public function resetCode(Request $request){
        $validator = Validator::make($request->all(), [
             'email' => 'required|email:rfc,dns',

        ], [
            'email.required' => 'Email est obligatoire.',
            'email.email' => 'Email doit être valide.',
        ]);
        if ($validator->fails()) {
            return redirect()->route("codeoublier")
                ->withErrors($validator);
        } 
        $email = $request->email;
        $message = "Le code ci-dessus est votre nouveau mot de passe vous pouvez le changer après connexion";
       $defaulPassword = substr(str_shuffle("1234567890"), 0, 6);
      $user =  DB::select('SELECT * FROM users WHERE email = :email',[ "email" => $request->email]);
      if(!empty($user)){
        $user = $user[0];
        $data = [
            "user" => $user->name,
            "Title" => "Réinitialisation de Mot de Passe",
            "Token" => $defaulPassword,
            "Content" => $message
        ];
        $newcode =  DB::table('users')->where('id',$user->id)->update([
            "password" => Hash::make($defaulPassword),
        ]);
        if(Mail::send('mails.codeoublier', $data, function ($content) use ($email) {
                $content->to($email, 'WORLY')->subject("WORLY");
                $content->from('contact@worly.com', 'WORLY');
            }) &&  $newcode > 0){
         Session::flash("success", "Un lien de réinitialisation à été envoyé à votre email.");   
        }else{
        Session::flash("fail", "Désolé une erreur s'est produite.");    
        }
      }else{
          Session::flash("fail", "Désolé une erreur s'est produite.");
      }
      return redirect()->route("login");
    }
    
    public function monCode(){
        return view("client.moncode");
    }
    
    public function resetMonCode(Request $request){
       $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ], [
            'password.min' => 'Mot de Passe doit être au moins 6 caractères.',
            'password.required' => 'Mot de Passe est obligatoire.',
            'password_confirmation.min' => 'Mot de Passe et la confirmation doivent êtres identiques.',
            'password_confirmation.required' => 'La confirmation du Mot de Passe est obligatoire.',
            'password.confirmed' => 'Mot de Passe et la confirmation doivent êtres identiques.'
        ]);
        if ($validator->fails()) {
            return redirect()->route("moncode")
                ->withErrors($validator);
        }  
        $moncode =  DB::table('users')->where('id',$request->id)->update([
            "password" => Hash::make($request->input('password')),
        ]);
        if ($moncode > 0) {
            Session::flash("success", "Mot de passe modifier avec succes.");
        } else {
            Session::flash("fail", "Désolé une erreur s'est produite.");
        }
        return redirect()->route("logout");
    }
}