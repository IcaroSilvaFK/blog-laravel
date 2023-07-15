<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class Home extends Controller
{
    public function index()
    {
        $posts = Post::with(['user','comments'])->limit(10)->orderby('id', 'desc')->get();

        return $posts;
    }

    public function store(Request $request){

        $input = $request->only(["title","content","user_id","slug"]);
        $post = Post::create([
            "title" => $input["title"],
            "content" => $input["content"],
            "user_id" => $input["user_id"],
            "slug" => $input["slug"],
            "thumb" => "https://picsum.photos/640/480",
        ]);

        // $post->title = $request->input("title");
        // $post->content = $request->input("content");
        // $post->user_id = $request->input("user_id");
        // $post->slug = $request->input("slug");
        // $post->thumb= "https://picsum.photos/640/480";
        // $post->save();

        return $input;
    }

    public function showById(Request $request, string $id)
    {
        $int = intval($id);

        $post = Post::with(["user","comments"])->where("id",$int)->first();

        return $post;
    }
}
