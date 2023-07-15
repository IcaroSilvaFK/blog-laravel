<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public static function index(Request $request):User
    {

        $input = $request->only(["firstName","lastName","email","password"]);

        $pass = Hash::make($input["password"]);

        $user = User::create([
            "firstName"=> $input["firstName"],
            "lastName"=> $input["lastName"],
            "email" => $input["email"],
            "password"=> $pass,
            "thumb" => "https://api.minimalavatars.com/avatar/minimal/png"
        ]);

        return $user;
    }

    public static function login(Request $request,Response $response)
    {

        $input = $request->only(["email","password"]);

        if(!isset($input["email"])){
            return response()->json(["message"=> "Email not provide please provide email","success"=>false],404);
        }

        $user = User::where("email",$input["email"])->first();

        if(!$user){
            return response()->json(["message"=> "Password or email invalid","success"=>false],401);
        }
        if(!Hash::check($input["password"],$user["password"])){
            return response()->json(["message"=> "Password or email is invalid","success"=>false],401);
        }

        return response()->json(["message"=> "User found","success"=>true,"user"=> $user],200);

    }


    public static function showPublications(Request $request, string $id)
    {
        $id = intval($id);

        $publications = Post::with(["comments","user"])->where("user_id",$id)->orderby("created_at","desc")->get();

        return $publications;
    }
}
