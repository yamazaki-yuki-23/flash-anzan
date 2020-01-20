<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use App\User;
use App\History;

class PlayController extends Controller
{
    public function index($level){
        if($level >= 1 && $level <= 3 && strlen($level) === 1){
            session([ 'level' => $level]);
            $play_option = Config::get('play_option.level'.$level);
            return view('play', compact('play_option', 'level'));
        }else{
            abort(404);
        }
    }

    public function result(Request $request){
        if(!$request->filled('score')){
            abort(404);
        }
        $level = session('level');
        $is_pb = false;
        $score = $request->input('score');
        $name = '';
        $data =  $this->score_check($score, $name, $is_pb);
        return view('result', ['name' => $data['name'], 'score' => $score,
            'is_pb' => $data['is_pb'], 'level' => $level]);
    }

    private function score_check($score, $name, $is_pb){
        if($score > 0){
            if(Auth::check()){
                $user = Auth::user();
                $name = $user->name;
                History::create([
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
