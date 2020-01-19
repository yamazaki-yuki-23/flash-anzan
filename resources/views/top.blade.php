@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <p class="alert alert-success">{{ session('status') }}</p>
            @endif

            <div class="card border-dark">
                <h1 class="card-header border-dark">フラッシュ暗算</h1>

                <div class="card-body pb-5">
                    <div class="rule">【ルール説明】
                        <ul>
                            <li>最初は簡単な問題から始まり、だんだん難しくなります</li>
                            <li>間違えた時点でゲームオーバーです。その時点での正解数がスコアになります</li>
                        </ul>
                    </div>
                    <div class="text-center mt-5">
                        <h4><b>挑戦するレベルを選んでね！</b></h4>
                    </div>
                    <div class="text-center mt-3">
                        <a href="/play/1" class="btn btn-outline-primary btn-lg">レベル1</a>
                        <a href="/play/2" class="btn btn-outline-secondary btn-lg ml-3">レベル2</a>
                        <a href="/play/3" class="btn btn-outline-success btn-lg ml-3">レベル3</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
