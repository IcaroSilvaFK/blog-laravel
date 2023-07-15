<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public static function index(Request $request)
    {
        $input = $request->only(["post_id","user_id","comment"]);

        $comment = Comment::create([
            "post_id" => $input["post_id"],
            "user_id" => $input["user_id"],
            "comment" => $input["comment"]
        ]);

        return $comment;
    }
}
