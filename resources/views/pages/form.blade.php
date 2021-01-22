@extends('layouts.index')

@section('content')
    <h1>ID3 ALGORITHM DEMO</h1>
    <form method="get" action="{{route('newForm')}}">
        @csrf
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
            <form method="post">
                @csrf
                <br><br>

                <label class="question"> {{$question->question}}</label>
                <br><br>
                <input hidden name="question_id" value="{{$question->id}}">
                @foreach($question->answers as $answer)
                    <input type="radio" id="entertainment-{{$answer->id}}"
                           name="answer_id" value="{{$answer->id}}">
                    <label for="entertainment-{{$answer->id}}">{{$answer->answer}}</label><br><br>
                @endforeach
                <input type="radio" name="answer_id" value="0">
                <label for="other">Other</label><br><br>
                <input style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/>

                <br><br>
                <button id="submit">Next Question</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("input[type='radio']").change(function () {

            if ($(this).val() == "0") {
                $("#otherAnswer").show();
            }
            else {
                $("#otherAnswer").hide();
            }
        });
    </script>
@endsection
