@extends('layouts.index')

@section('content')
    <h1>ID3 ALGORITHM DEMO</h1>
    <form method="get" action="{{route('newForm')}}">
        <button name="new" id="submit">start new</button>
    </form>
    <div class="quiz-container">
        <div id="quiz">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
                <br><br>
                <label class="question"> Thank you!</label>
                <br><br>
        </div>
    </div>
@endsection

