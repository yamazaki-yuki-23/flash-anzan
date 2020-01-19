@extends('layouts.app')

@section('head')
    <style>
        .pagination{
            justify-content: center;
        }

        .history__score{
            font-size: 3rem;
        }

        .history__table {
            max-width: 20rem;
            margin-left: auto;
            margin-right: auto;
        }

        .history__nohistory {
            font-size: 1.25rem;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header text-muted">プレイ履歴</h1>

                    <div class="card-body history pb-5">
                        @if($histories->isEmpty())
                            <p class="history__nohistory text-center">まだプレイ履歴がありません。</p>
                        @else
                            <p class="text-center">{{ $user->name }}さんの最高スコアは</p>
                            <p class="history__score text-center">{{ $user->personal_best }}</p>
                            <div class="history__table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>プレイ日時</th>
                                            <th class="text-center">スコア</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($histories as $history)
                                            <tr>
                                                <td>{{ $history->created_at->format('Y/m/d H:i') }}</td>
                                                <td class="text-center">{{ $history->score }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $histories->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
