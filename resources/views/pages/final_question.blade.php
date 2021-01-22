@extends('layouts.index')

@section('content')
    <h1>ID3 ALGORITHM DEMO</h1>
    <form method="get" action="{{route('newForm')}}">
        <button name="new" id="submit">start new</button>
    </form>
    <form method="post" action="{{route('changeLanguage')}}">
        <p>Languages</p>
        @csrf
        <select name="language">
            @foreach($languages as $language)
                <option
                        @if((Session::has('language') ? Session::get('language') : 'en') == $language->iso_639)
                        selected
                        @endif
                        value="{{$language->iso_639}}">
                    {{$language->name}}
                </option>
            @endforeach
        </select>
        <button id="submit">Change</button>
    </form>
    <div class="quiz-container">
        <div id="quiz">
            <form method="post" action="{{route('final')}}">
                @csrf
                <br><br>

                <label class="question"> {{\Illuminate\Support\Facades\Session::get('final_question')}}</label>
                <br><br>
                    <input type="radio" id="entertainment-1"
                           name="answer" value="1">
                    <label for="entertainment-1">Yes</label>
                <br><br>
                <input type="radio" id="entertainment-2"
                       name="answer" value="0">
                <label for="entertainment-2">No</label><br><br>
                <button id="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

