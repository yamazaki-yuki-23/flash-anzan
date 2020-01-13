@extends('layouts.app')

@section('content')
<number-panel url="{{ route('result') }}">
    @csrf
</number-panel>
@endsection

@section('script')
    <script type="application/json" id="play_option">@json($play_option)</script>
@endsection
