@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <p class="alert alert-success">{{ session('status') }}</p>
            @endif

            <div class="card">
                <h1 class="card-header">フラッシュ暗算</h1>

                <div class="card-body pb-5">
                    <p>表示された数字を足していくだけのシンプルなゲームです。<br>
                        ぜひ皆さんもチャレンジして、脳を鍛えましょう！
                    </p>
                    <ul>
                        <li>最初は簡単な問題から始まり、だんだん難しくなります</li>
                        <li>間違えた時点でゲームオーバーです。その時点での正解数がスコアになります</li>
                    </ul>
                    <div class="text-center mt-5">
                        <a href="{{ route('play') }}" class="btn btn-primary btn-lg">ゲームをはじめる</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
