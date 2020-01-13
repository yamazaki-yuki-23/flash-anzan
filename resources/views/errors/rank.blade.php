@extends('layouts.app')

@section('head')
<style>
    .error_message {
        font-size: 1.25rem;
    }
</style>
@endsection


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="card-header text-muted">ランキング</h1>

                    <div class="card-body history pb-5">
                        <p class="text-center error_message">
                            {{ $message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
