<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Contracts\Auth;

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

        return response($user, 201);
    }

    public static function login(Request $request)
    {
        //TODO validate request
        $input = $request->validate([
            "email" => ["required","email"],
            "password" => ["required"]
        ]);
        if(!auth()->attempt($input)){
            return response()->json(["message" => "Password or email invalid","success"=>false],401);
        }


        $token = auth()->user()->createToken('personal-token',expiresAt:now()->addDay())->plainTextToken;

        return response()->json(["token"=>$token,"success"=>true],200);
    }

    public static function me(Request $request){

        $user = auth()->user();


        return response($user,200);
    }


    public static function showPublications(Request $request, string $id)
    {
        $id = intval($id);

        $publications = Post::with(["comments","user"])->where("user_id",$id)->orderby("created_at","desc")->get();

        return $publications;
    }

    public static function destroy(Request $request, string $id)
    {
        $id = intval($id);

        if(!$id){
            return response()->json(["message"=>"Id not provide please provide id","success"=>false],404);
        }

        User::destroy($id);


        return response("",204);
    }
}
