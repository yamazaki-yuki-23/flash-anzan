<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use App\User;
use App\History;

class PlayController extends Controller
{
    public function index(){
        $play_option = Config::get('play_option');
        return view('play', compact('play_option'));
    }

    public function result(Request $request){
        if(!$request->filled('score')){
            abort(400,'無効なURLです。');
        }

        $is_pb = false;
        $score = $request->input('score');
        $name = '';
        $data =  $this->score_check($score, $name, $is_pb);
        return view('result', ['name' => $data['name'], 'score' => $score, 'is_pb' => $data['is_pb']]);
    }

    private function score_check($score, $name, $is_pb){
        if($score > 0){
            if(Auth::check()){
                $user = Auth::user();
                $name = $user->name;
                History::created([
                    'user_id' => $user->id,
                    'score' => $score,
                ]);
                if($user->personal_best < $score){
                    $user->personal_best = $score;
                    $user->save();
                    $is_pb = true;
                }
            }else{
                session([ 'score' => $score]);
            }
        }
        return $data = ['name' => $name, 'is_pb' => $is_pb];
    }
}
