<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Config;
use App\Models\Language;
use App\Models\Question;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Done: 1) saving form / 2) flow after 'other' answer added / 3) saving not expected final answer
    //
    // Languages db https://github.com/Voles/MySQL-ISO-639-1-language-codes/blob/master/db.sql
    public function index()
    {
        $languages = Language::all();
//        dd(GoogleTranslate::trans('Hello again', 'ca'));
//        dd(Session::has('answers'));
//        Session::forget('answers');
//        Session::save();
//        dd('done');

        if ($this->isMinAmountOfRecordsExists()) {
            // flag to get from id3 to normal questionary flow whenever encounter 'other' answer
            $backToNormalFlow = Session::has('backToNormalFlow') ? Session::get('backToNormalFlow') : false;

            if (!$backToNormalFlow) {
                $question = $this->id3();
            } else {
                $question = $this->backToNormalFlow();
            }

            if (!$question) {
                // questions are over
//            dd('final question');
                return view('pages.final_question');
            }

            // if there any chosen language -> translate question and answers
            if ($this->chosenLanguage()) {
                    $question->question = $this->translate($question->question);

                foreach ($question->answers as $answer) {
                    $answer->answer = $this->translate($answer->answer);
                }
            }
            return view('pages.form', compact('question', 'languages'));
        } else {
            $questions = $this->allQuestions();
            if ($this->chosenLanguage()) {
                foreach ($questions as $question) {
                    $question->question = $this->translate($question->question);

                    foreach ($question->answers as $answer) {
                        $answer->answer = $this->translate($answer->answer);
                    }
                }
            }
            $finalQuestion = $this->finalQuestion();

            return view('pages.normal_form', compact('questions', 'finalQuestion', 'languages'));
        }
    }

    // do we have enough records in db
    public function isMinAmountOfRecordsExists()
    {
        return Config::where('name', 'min_records')->first()->value <= Record::count();
    }

    public function id3()
    {
//        Session::forget('answers');
//        Session::save();
        $sessionAnswers = Session::has('answers') ? Session::get('answers') : [];
        // already passed questions
        $visitedQuestions = array_keys($sessionAnswers);//[1,2,3];

//        dd( Session::has('answers'));
        // answers for already passed questions
        $visitedAnswers = array_values($sessionAnswers);//[1,5,7];
        $visitedRecordsIds = [];

        if (empty($visitedQuestions)) {
            // if person start questionnaire (form)
            $questions = Question::all();
        } else {
            // if person already answered for one(many) a question(s)
            foreach ($visitedAnswers as $answerId) {
                if (empty($visitedRecordsIds)) {
                    $records = Record::whereHas('answers', function ($query) use ($answerId) {
                        return $query->where('id', $answerId);
                    })->pluck('id')->toArray();
                } else {
                    $records = Record::whereHas('answers', function ($query) use ($answerId) {
                        return $query->where('id', $answerId);
                    })->whereIn('id', $visitedRecordsIds)->pluck('id')->toArray();
                }
//            dd($records);
                $visitedRecordsIds = $records;
            }
//            dd($visitedRecordsIds);

            // if we have only one record -> need to ask final question
            if (count($visitedRecordsIds) === 1) {
                Session::put('final_question', $this->finalQuestion());
                Session::put('expected_final_answer', $this->expectedFinalAnswer($visitedRecordsIds[0]));

                return 0;
            }

            // get array of next question, ids of question can re
            $possibleQuestionsIds = Answer::whereHas('records', function ($query) use ($visitedRecordsIds) {
                return $query->whereIn('id', $visitedRecordsIds);
            })->whereNotIn('questions_id', $visitedQuestions)->groupBy('questions_id')->pluck('questions_id')->toArray();

//            dd($possibleQuestionsIds);
            $questions = Question::whereIn('id', $possibleQuestionsIds)->get();
        }

        $questionIdWithHighestGain = 0;
        $highestGain = 0;

//      dd($questions->toArray());
        foreach ($questions as $question) {
            // if person start questionnaire (form)
            if (empty($visitedQuestions)) {
                $answers = Answer::where('questions_id', $question->id)->with('records')->get();
            } else {
                $answers = Answer::with(['records' => function ($query) use ($visitedRecordsIds) {
                    $query->whereIn('id', $visitedRecordsIds);
                }])->where('questions_id', $question->id)->get();
            }

//            dd($answers->toArray());
            $totalAnswers = 0;
            $totalPositives = 0;
            $everyAnswers = [];

            foreach ($answers as $answer) {
//                dd($visitedRecordsIds);
//                dd($answer->records->toArray());
                $sumOfFinal = $answer->records->count('final');
                $sumOfPositives = $answer->records->sum('final');

                $totalAnswers += $sumOfFinal;
                $totalPositives += $sumOfPositives;
                $everyAnswers[] = [
                    'sum' => $sumOfFinal,
                    'p' => $sumOfPositives
                ];
            }

            $gain = round(
                $this->gain(
                    $everyAnswers,
                    $totalAnswers,
                    $totalPositives
                ),
                3
            );
            var_dump('our current gain -> ' . $gain);
            if ($gain > $highestGain) {
                var_dump('now highest gain is = ' . $gain);
                var_dump('now quiestion id = ' . $question->id);
                $highestGain = $gain;
                $questionIdWithHighestGain = $question->id;
            }
        }

        // if highest gain equal to '0' (zero)
//        dd($visitedRecordsIds);
        if (!$highestGain) {
            Session::put('final_question', $this->finalQuestion());
            //take first visited record, all of them have similar final result (either yes = 1 or no = 0)
            Session::put('expected_final_answer', $this->expectedFinalAnswer($visitedRecordsIds[0]));

            return 0;
        }

        return Question::with('answers')->where('id', $questionIdWithHighestGain)->first();
    }

    public function entropyCount($sum, $p)
    {
        if ($sum == $p || $p == 0) {
            return 0;
        }

        $ent = floatval(((-$p / $sum) * log(($p / $sum), 2)) - ((($sum - $p) / $sum) * log(($sum - $p) / $sum, 2)));

        return $ent;
    }

    public function iCount($sum, $totalSum)
    {
        return floatval($sum / $totalSum);
    }

    public function gain($answers, $totalSum, $totalP)
    {
        $iTotal = 0;
        foreach ($answers as $answer) {
            $sum = $answer['sum'];
            $p = $answer['p'];
            $entropy = $this->entropyCount($sum, $p) ?? 0;

            $iTotal += $entropy * $this->iCount($sum, $totalSum);
        }

        return $this->entropyCount($totalSum, $totalP) - $iTotal;
    }

    public function finalQuestion()
    {
        $finalQuestion = Config::where('name', 'last_question')->first()->value;

        if ($this->chosenLanguage()) {
            $finalQuestion = $this->translate($finalQuestion);
        }

        return $finalQuestion;
    }

    public function expectedFinalAnswer($recordId)
    {
        return Record::find($recordId)->final;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function formSubmitted(Request $request)
    {
        $questionId = $request->question_id;

        if (Session::has('answers')) {
            $answers = Session::get('answers');
        }

        // if answer exist in provided one
        if ($request->answer_id) {
            $answers[$questionId] = $request->answer_id;
        } else {
            $newAnswer = $request->otherAnswer;
            //translate any answers to English
            $newAnswer = $this->translate($newAnswer, 'en');
            //or create that(other) answer and add it in the record
            $otherAnswer = new Answer;
            $otherAnswer->answer = $newAnswer;
            $otherAnswer->questions_id = $questionId;
            $otherAnswer->save();

            $answers[$questionId] = $otherAnswer->id;

            Session::put('backToNormalFlow', true);
        }

        Session::put('answers', $answers);

        return redirect()->route('form');
    }

    public function finalQuestionSubmitted(Request $request)
    {
        if ($request->answer == Session::get('expected_final_answer')) {
            //dd('as expected');
            $this->cleanSession();
            return redirect()->route('thank');
        } else {
            //dd('not expected');
            $this->saveNewRecord($request->answer);
            return redirect()->route('thank')
                ->with('success', sprintf('New data have been saved!'));
        }
    }

    public function saveNewRecord($finalAnswer)
    {
        $record = new Record;
        $record->final = $finalAnswer;
        $record->save();

        $sessionAnswers = Session::has('answers') ? Session::get('answers') : [];
        $record->answers()->attach($sessionAnswers);
    }

    public function cleanSession()
    {
        Session::forget('answers');
        Session::save();
    }

    public function startNewForm(Request $request)
    {
        $this->cleanSession();
        return redirect()->route('form');
    }

    //ask all(rest) questions after putting other answer to any question
    public function backToNormalFlow()
    {
        $sessionAnswers = Session::has('answers') ? Session::get('answers') : [];
        $visitedQuestions = array_keys($sessionAnswers);

        $question = Question::with('answers')
            ->whereNotIn('id', $visitedQuestions)
            ->first();

        // if no question left -> time to ask final question
        if (!isset($question->id)) {
            Session::put('final_question', $this->finalQuestion());

            return 0;
        }

        return $question;
    }

    public function allQuestions()
    {
        return Question::with('answers')->get();
    }

    public function saveNormalForm(Request $request)
    {
        $newAnswers = [];

        $record = new Record;
        $record->final = $request->finalAnswer;
        $record->save();

        foreach ($request->answers as $questionId => $answerId) {
            if ($answerId) {
                $newAnswers[$questionId] = $answerId;
            } else {
                //or create that(other) answer and add it in the record
                $newAnswer = $request->otherAnswers[$questionId];
                $newAnswer = $this->translate($newAnswer, 'en');
                $otherAnswer = new Answer;
                $otherAnswer->answer = $newAnswer;
                $otherAnswer->questions_id = $questionId;
                $otherAnswer->save();

                $newAnswers[$questionId] = $otherAnswer->id;
            }
        }

        $record->answers()->attach($newAnswers);
        return redirect()->route('thank')
            ->with('success', sprintf('New data have been saved!'));
    }

    public function thank()
    {
        return view('pages.thank');
    }

    public function changeLanguage(Request $request) {

        Session::put('language', $request->language);
        return redirect()->back();
    }


    public function translate($sentances, $language = '') {
        try {
            $translated = GoogleTranslate::trans($sentances, !empty($language) ? $language : $this->chosenLanguage());
            return $translated;
        } catch (\Exception $e) {
            // not all languages supported in Google Cloud translate. Just clean it if any problems
            Session::forget('language');
            Session::save();
            return $sentances;
        }
    }

    public function chosenLanguage() {
        return Session::has('language') ? Session::get('language') : false;
    }
}
