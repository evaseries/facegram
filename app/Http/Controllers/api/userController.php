<?php

namespace App\Http\Controllers\api;
use App\Models\follow;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{

public function getalluser(Request $request)
{
    $user = User::get();
    return response()->json($user);
}

public function getUsersNotFollowedByLoggedInUser()
{
    // Ambil ID pengguna yang sudah login
    $loggedInUserId = Auth::id();

    // Ambil pengguna yang belum diikuti oleh pengguna yang sudah login
    $usersNotFollowedByLoggedInUser = User::whereNotIn('id', function($query) use ($loggedInUserId) {
        $query->select('followed_user_id')
              ->from('followers')
              ->where('follower_user_id', $loggedInUserId);
    })
    ->where('id', '<>', $loggedInUserId) // Sembunyikan pengguna yang sudah login
    ->get();

    return response()->json([
        'users' => $usersNotFollowedByLoggedInUser
    ], 200);
}
public function getUserDetails($id)
{
    $user = User::with('posts')->find($id);

    if ($user->is_private) {
        $followStatus = follow::where('follower_user_id', Auth::id())
            ->where('followed_user_id', $user->id)
            ->value('status');

        if ($followStatus === 'not following' || $followStatus === 'requested') {
            $user->makeHidden('posts');
        }
    }

    return response()->json([
        'user' => $user
    ], 200);
}
    public function getUsersNotFollowedByUser($id)
    {
        $user = User::with('')->find($id);
        if ($user->is_private) {
            $followStatus = follow::where('', Auth::id())
            ->where('', $user->id)
            ->value('status');
        }
        return response()->json([
            'user'=> $user
            ], 200);
}
public function followUser($id, Request $request)
{
    $user = User::with('')->find($id);
    if ($user->is_private) {
        $followStatus = follow::where('', Auth::id())
        ->where('', $user->id)
        ->value('status');
        if ($followStatus === ''|| $followStatus === '')
        $followStatus = follow::where('',
    Auth::id())
    ->where('', $user->id)
    ->value('status');}
    return response()->json([
        'user'=> $user
        ], 200);
    }
}
