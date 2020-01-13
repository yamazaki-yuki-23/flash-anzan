@extends('layouts.app')

@section('head')
    <style>
    .pagination {
        justify-content: center;
    }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('status'))
                    <p class="alert alert-success">{{ session('status') }}</p>
                @endif

                <div class="card">
                    <h1 class="card-header text-muted">ランキング</h1>

                    <div class="card-body">
                        @if($data['user_rank'] > 0)
                            <p class="text-center">{{ $data['user']->name }}　さんのランキングは</p>
                            <p class="text-center">
                                <span style="font-size: 1.5rem;">{{ $data['user_rank'] }}位</span> / {{ $data['ranking_count'] }}人中
                            </p>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">順位</th>
                                    <th class="text-center">名前</th>
                                    <th class="text-center">スコア</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ranking as $player)
                                    <tr>
                                        <td class="text-center">{{ $player->rank }}</td>
                                        <td class="text-center">{{ $player->name }}</td>
                                        <td class="text-center">{{ $player->personal_best }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $ranking->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
