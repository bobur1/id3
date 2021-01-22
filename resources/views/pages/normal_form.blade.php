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
            <form method="post" action="{{route('submitNormalForm')}}">
                @csrf
                <br><br>

                @foreach($questions as $question)
                <label class="question"> {{$question->question}}</label>
                <br><br>
                @foreach($question->answers as $answer)
                    <input type="radio" id="entertainment-{{$answer->id}}"
                           name="answers[{{$question->id}}]" value="{{$answer->id}}">
                    <label for="entertainment-{{$answer->id}}">{{$answer->answer}}</label><br><br>
                @endforeach
                <input type="radio" name="answers[{{$question->id}}]" value="0">
                <label for="other-{{$question->id}}">Other</label>
                <input style="display:none;" type="text" name="otherAnswers[{{$question->id}}]" class="otherAnswer other-{{$question->id}}"/>
                    <br><br>
                @endforeach
                <br><br>
                <label class="question"> {{$finalQuestion}}</label>
                <br><br>
                <input type="radio" id="entertainment-1"
                       name="finalAnswer" value="1">
                <label for="entertainment-1">Yes</label>
                <br><br>
                <input type="radio" id="entertainment-2"
                       name="finalAnswer" value="0">
                <label for="entertainment-2">No</label><br><br>
                <button id="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("input[type='radio']").change(function () {

            if ($(this).val() == "0") {
                $(this).next().next().show();
            }
        });
    </script>
@endsection
