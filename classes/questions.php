<?php

include ('DbConnection.php');
class Questions
{

    const FINAL_TRUE = 'Go to the cinema';
    const FINAL_FALSE = 'Stay at home';
    const ANSWERS_COOKIE_NAME = 'answers';
    const POST_VISITED_QUESTIONS_ANSWERS = 'visited_questions_answers';

    public function id3()
    {
        $visited_questions_answers = $this->getSession(self::POST_VISITED_QUESTIONS_ANSWERS);
        //db obkect
//        var_dump('saved answers --> ');
//        var_dump($visited_questions_answers);
//        var_dump('<br>');
        $Dbobj = new DbConnection();
        $conn = $Dbobj->getdbconnect();

        //$visited_questions_answers = [1=>2]; //1=>1,2=>5
        $selectedRecords = [];
        $visited_questions = [];

        if(!empty($visited_questions_answers)) {
            foreach ($visited_questions_answers as $answers_id) {
                $sql3 = "select distinct records.id from records
					 join records_answers on records_answers.records_id = records.id
                 where records_answers.answers_id = {$answers_id}";

                if (!empty($selectedRecords)) {
                    $sql3 .= " and records.id in (" . implode(', ', $selectedRecords) . ")";
                }

                $rows3 = $conn->query($sql3)->fetch_all(MYSQLI_ASSOC);

                if (!empty($rows3)) {
                    reset($selectedRecords);
                    $selectedRecords = [];
                    foreach ($rows3 as $record) {
                        $selectedRecords[] = $record['id'];
                    }
                }
            }
//            var_dump($selectedRecords);
//            die();
            //get Questions id
            $sql4 = 'SELECT distinct questions_id from answers where id in ('. implode(', ', array_values($visited_questions_answers)) .');';

            $visited_questions_row = $conn->query($sql4)->fetch_all(MYSQLI_ASSOC);
            foreach ($visited_questions_row as $question_id) {
                $visited_questions[] = $question_id['questions_id'];

            }
//            var_dump($visited_questions);
//            die();
        }

        $sql = 'SELECT answers.questions_id, answers.id as answers_id, 
                        count(records.id) as amount, 
                        sum(records.final) as positive
                FROM (select * from answers ';
        if(!empty($visited_questions_answers)) {
            $sql .= ' where answers.questions_id not in (' . implode(', ', $visited_questions) . ')';
        }
        $sql .= ') as answers 
                 join records_answers on records_answers.answers_id = answers.id
                 join records on records.id = records_answers.records_id ';
        if (!empty($selectedRecords)) {
            $sql .= " and records.id in (" . implode(', ', $selectedRecords) . ") ";
        }
        $sql .=' group by answers.id';
//        var_dump($sql);
        $rows = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

//                var_dump('<pre>');
//                var_dump($rows);
//                var_dump('</pre>');
//                die();

        $sql2 = 'select count(distinct records.id) as total, sum(records.final)*count(DISTINCT records.id)/count(*) as positives
					 from records
					 join records_answers on records_answers.records_id = records.id
                join answers on answers.id = records_answers.answers_id';

        if (!empty($selectedRecords)) {
            $sql2 .= " and records.id in (" . implode(', ', $selectedRecords) . ")";
        }

//        var_dump($sql2);
//        die();

        $row = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);

        if (isset($row[0]['total'])) {
            if ($row[0]['total'] == $row[0]['positives']) {
//                var_dump('Final answer -> Yes');
                return 1;
            } elseif( $row[0]['positives'] == 0){
//                var_dump('Final answer -> No');
                return 0;
            }
        }
//        var_dump($row);
//        die();

        $highestId = 0;
        $currentQuestions = [];
        $length = count($rows)-1;

        foreach ($rows as $key=>$question) {
            if (!empty($visited_questions_answers) && in_array($question['questions_id'], $visited_questions)) {
                continue;
            }

            if (($question['amount']
                    && !empty($currentQuestions)
                    && $currentQuestions['questions_id'] != $question['questions_id']
                ) || $lastRow=($key === $length)) {
                if ($lastRow) {
                    $currentQuestions['answers'][$key]['sum'] = $question['amount'];
                    $currentQuestions['answers'][$key]['p'] = $question['positive'];
                }

//                var_dump('<pre>');
//                var_dump($currentQuestions);
//                var_dump('</pre>');
//                die();

                $gain = round($this->gain($currentQuestions,
                    $row[0]['total'],
                    $row[0]['positives']
                ),
                    3
                );
                $highestId = $highestId > $gain ? $highestId : $currentQuestions['questions_id'];
                unset($currentQuestions['answers']);
                $currentQuestions = [];
//                var_dump('<br> Gain = '.$gain.'<br>');
            }

            if (empty($currentQuestions)) {
                $currentQuestions['questions_id'] = $question['questions_id'];
            }

            $currentQuestions['answers'][$key]['sum'] = $question['amount'];
            $currentQuestions['answers'][$key]['p'] = $question['positive'];
        }
//        var_dump('<br> highest'.$highestId.'<br>');
        $sql3 = "SELECT questions.*, answers.id as answers_id, answers.answer
                FROM questions
                left join answers on questions.id = answers.questions_id
                where questions.id = {$highestId}
                ";
        $rows = $conn->query($sql3)->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public function gain($questions, $totalSum, $totalP) {
        $iTotal = 0;
        foreach ($questions['answers'] as $answer) {
            $sum = $answer['sum'];
            $p = $answer['p']; // positive
            $entropy = $this->entropyCount($sum, $p) ?? 0;

            $iTotal += $entropy * $this->iCount($sum, $totalSum);
        }

        return $this->entropyCount($totalSum, $totalP) - $iTotal;
    }

    public function entropyCount ($sum, $p) {
        if($sum == $p || $p == 0) {
            return 0;
        }

        $ent = floatval(( (-$p/$sum ) * log(($p/$sum),2) ) - ( (($sum - $p)/$sum) * log(($sum - $p)/$sum,2) ));

        return $ent;
    }

    public function iCount($sum, $totalSum) {
        return floatval($sum/$totalSum);
    }

    public function saveAnsweredQuestion($currentAnswer){
        $visited_questions_answers = $this->getSession(self::POST_VISITED_QUESTIONS_ANSWERS);

        var_dump('<br>$visited_questions_answers --> ');
        var_dump('<pre>');
        var_dump($visited_questions_answers);
        var_dump('</pre>');
        if (!empty($visited_questions_answers) && !empty($currentAnswer)) {
             $visited_questions_answers = array_unique(array_merge($visited_questions_answers, $currentAnswer));
        } else {
//            var_dump('<br>not entered ');
            $visited_questions_answers = $currentAnswer;
        }
        $this->saveSession(self::POST_VISITED_QUESTIONS_ANSWERS, $visited_questions_answers);
    }

    public function saveSession($session_name, $session_value) {
//        var_dump('<br>Post values --> ');
//        var_dump('<pre>');
//        var_dump($session_value);
//        var_dump('</pre>');
        $this->deleteSession();
        $_SESSION[$session_name] = $session_value;
    }

    public function getSession($session_name) {
        return $_SESSION[$session_name] ?? [];
    }

    public function deleteSession() {
        unset($_SESSION[self::POST_VISITED_QUESTIONS_ANSWERS]);
    }

    public function needToInsertData(){
        $Dbobj = new DbConnection();
        $conn = $Dbobj->getdbconnect();

        $sql = 'SELECT count(id) as amount from records';
        $amountOfRecordsRow = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
//                var_dump('<pre>');
//        var_dump($amountOfRecordsRow[0]['amount']);
//        var_dump('</pre>');
//        die();
        return $amountOfRecordsRow[0]['amount'] < 13;
    }

    public function ordinaryQuestionsFlow (){
        $Dbobj = new DbConnection();
        $conn = $Dbobj->getdbconnect();
        if(isset($_POST['final_answer'])) {
            $this->save();
        }
        $question_id = $_POST['question_id'] ?? 0;

        $sql3 = "SELECT questions.*, answers.id as answers_id, answers.answer ";
        if ($question_id) {
            $question_id ++;
            $sql3 .= " FROM questions
                left join answers on questions.id = answers.questions_id 
                where questions.id = " . $question_id;
        } else {
            $sql3 .= " FROM (select questions.* from questions limit 1) as questions
                left join answers on questions.id = answers.questions_id";
        }
//                        var_dump('<pre> ====>');
//                        var_dump($sql3);
//        die();
//        var_dump($conn->query($sql3)->fetch_all(MYSQLI_ASSOC));
//        var_dump('</pre>');
//        die();
        $next_question = $conn->query($sql3)->fetch_all(MYSQLI_ASSOC);

        if (empty($next_question)) {
            $_SESSION['final_question'] = true;
//            var_dump('here?'.$_SESSION['final_question']);
            return 0;
        }

        return $next_question;
    }

    public function save()
    {
        $final_answer = $_POST['final_answer'] ?? 0;
        $visited_questions_answers = $this->getSession(self::POST_VISITED_QUESTIONS_ANSWERS);
        if (!empty($final_answer) && !empty($visited_questions_answers)) {
            $Dbobj = new DbConnection();
            $conn = $Dbobj->getdbconnect();
            $sql = "INSERT INTO records (final) VALUES ('" . intval($final_answer) . "')";
            //check if there any errors in inputting first table (products)
            var_dump('new record answer '.$final_answer);
            if (mysqli_query($conn, $sql) == TRUE) {
                var_dump('new record');
                $record_id = mysqli_insert_id($conn);

                $sql2 = "INSERT INTO attributes (records_id, answers_id) VALUES ";
                foreach ($visited_questions_answers as $answer_id) {
                    $sql2.= '('.$record_id .','. $answer_id.')';
                }
            }

            var_dump('or no record');
        }
        $this->deleteSession();
        unset($_POST['final_answer']);
        unset($_SESSION['final_question']);
        unset($_POST['answer']);
        unset($_POST['question_id']);
    }

}