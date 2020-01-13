<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\History;

class HistoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $user = Auth::user();
        $histories = History::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);
        return view('history', compact('user', 'histories'));
    }
}
