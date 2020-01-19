@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1 class="mb-4">
            @if($level == 1)
                <span class="badge badge-primary">レベル{{$level}}</span>
            @elseif($level == 2)
                <span class="badge badge-secondary">レベル{{$level}}</span>
            @else
                <span class="badge badge-success">レベル{{$level}}</span>
            @endif
        </h1>
    </div>
</div>
<number-panel url="{{ route('result') }}">
    @csrf
</number-panel>
@endsection

@section('script')
    <script type="application/json" id="play_option">@json($play_option)</script>
@endsection
