<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\History;
use Config;

class RankController extends Controller
{
    public function index(Request $request){
        $items_per_page = Config::get('const.items_per_page');
        $ranking_query = User::where('personal_best', '>', 0)->orderBy('personal_best', 'desc');
        $ranking = $ranking_query->simplePaginate($items_per_page);

        $this->is_ranking_empty($ranking);

        $page = (int)$request->input('page', 1);
        $this->page_branch($page, $ranking);
        $data = $this->calculate_rank($ranking_query);
        return view('rank', compact('ranking', 'data'));
    }

    private function is_ranking_empty($ranking){
        if($ranking->isEmpty()){
            abort(500, 'まだランキングにデータがありません。');
        }
    }

    private function page_branch($page, $ranking){
        if($page === 1){
            $rank = 1;
            $index = 0;
            $old_score = 0;
        }else{
            $old_score = $ranking->first()->personal_best;
            $rank = User::where('personal_best', '>', $old_score)->count();
            $rank++;
            $index = $items_per_page * ($page - 1);
        }

        foreach($ranking as $player){
            $index++;
            if($player->personal_best !== $old_score){
                $old_score = $player->personal_best;
                $rank = $index;
            }
            $player->rank = $rank;
        }
    }

    private function calculate_rank($ranking_query){
        $user = '';
        $user_rank = '';
        if(Auth::check()){
            $user = Auth::user();
            if($user->personal_best > 0){
                $user_rank = User::where('personal_best', '>', $user->personal_best)->count();
                $user_rank++;
            }
        }
        $ranking_count = $ranking_query->count();
        return $data = ['user' => $user,'user_rank' => $user_rank,'ranking_count' => $ranking_count];
    }
}
