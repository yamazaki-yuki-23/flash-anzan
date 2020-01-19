@extends('layouts.app')

@section('head')
    <style>
        .result {
            width: 25rem;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        .result__score {
            font-size: 5rem;
        }
        .result__pb {
            font-size: 1.25rem;
        }
        .result__invite {
            text-align: center;
        }
        .result__member {
            text-align: center;
        }
        .result__member > a {
            margin-left: 1rem;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header text-muted">結果発表</h1>

                    <div class="card-body pb-5">
                        <div class="result">
                            <p class="text-center">{{ $name !== ''  ? "$name さん" : 'あなた' }}のスコア</p>
                            <p class="result__score text-center">{{ $score }}</p>
                            @if('is_pb')
                                <p class="result__pb text-center">自己ベスト更新！</p>
                            @endif

                            <div class="mt-5">
                                @guest
                                    <p class="result__invite">
                                        <span class="d-inline-block">会員登録をして、</span>
                                        <span class="d-inline-block">スコア登録をしませんか?</span>
                                    </p>
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-block btn-lg">会員登録</a>
                                    <p class="result__member mt-3">アカウントをお持ちの場合は
                                        <a href="{{ route('login') }}">ログイン</a>
                                    </p>
                                @else
                                    <a href="{{route('play', ['level' => $level]) }}" class="btn btn-primary btn-block btn-lg">もう一回</a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
