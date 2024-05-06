<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\post;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

class postController extends Controller
{
  public function create(Request $request)
  {
    try
    {
      $validate = $request->validate([
        "caption"=> "required",
        "attachment"=> "required|file|mimes:jpg,jpeg,webp,png,gif"
        ]);

        $post = post::create([
                "caption"=> $validate["caption"],
                "attachment"=> $validate["attachment"],
        ]);

        return response()->json([
        "message" => "Create post success",
        "post"=> $post
        ],201);
    }
    catch (\Exception $e)
    {
        return response()->json([
            "message" => "Invalid field",
            "error"=> $e->getMessage()
            ]);
    }
}
    public function getpost(Request $request)
    {
        try
        {
            $validate = $request->validate([
                "page"=> "integer|min:0",
                "size"=> "integer|min:1",]);
            $post = post::get();
            $user = User::get();
            $post->page = $request->page;
            $post->size = $request->size;
            $post->save();
            return response()->json([
                "size" => $post->size,
                "page" => $post->page,
                "post" => $post,
                "user"=> $user
                ]);
    }
    catch (\Exception $e)
    {
        return response()->json([
            "message"=> "
            ",
            "error"=> $e->getMessage()
            ]);
}
}
     public function delete($id )
     {
        try
            {
                $post = post::findOrFail($id);
                if( ! $post)
                {
                    return response()->json([
                        "message"=> "not found"
                    ],404);
            }
            if( $post->user_id != $user->id )
            {
                return response()->json([
                    "message"=> "you can delete other user post"
                    ],401);
            $post->delete();
            return response()->json([
                "message"=> "post deleted"
            ],200);
        }
        catch (\Exception $e)
        {
            return response()->json([
                "message"=> ""
            ]);
        }
    }
}
