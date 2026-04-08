<?php

namespace App\Http\Controllers;

use App\Events\JoinLobby;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $code)
    {
        $quiz = Quiz::where('code', $code)->get();
        // Second one is better but im too lazy xD
        // $quiz = Quiz::where('code', $code)->firstOrFail();

        $user = Auth::user();
        $userOwner = "";
        $quizzes = $user->quizzes;
        $userStatus = "";
        $ownerId=0;
        $iconLabel = "";

        $name = $user->first_name ?? "";

        $first = $name[0] ?? "";

        $last = "";
        for ($i = strlen($name) - 1; $i >= 0; $i--) {
            if (ctype_alpha($name[$i])) {
                $last = $name[$i];
                break;
            }
        }

        $iconLabel = strtoupper($first . $last);

        if ($quiz && $user->quizzes->contains('id', $quiz[0]->id)) {
            $userStatus = "owner";
            $userOwner = $user->first_name;
            $ownerId = $user->id;
        } else {
            $userStatus = "participant";
            $ownerId =  $quiz[0]->user->id;
            $userOwner = $quiz[0]->user->first_name;
        }

        return view('lobby', compact('quiz', 'userStatus', 'user', 'userOwner', 'ownerId', 'iconLabel'));
    }

    public function join(string $code){
        $quiz = Quiz::where('code', $code)->firstOrFail();
        $user = Auth::user();

        JoinLobby::broadcast($user->id, $quiz->code, $user->username);

        return response()->json(['status' => 'ok']);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
