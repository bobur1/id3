<?php

include ('DbConnection.php');
class Questions
{

    const ANSWERS_COOKIE_NAME = 'answers';

    public function show()
    {
        //db obkect
        $Dbobj = new DbConnection();
        $conn = $Dbobj->getdbconnect();
        $sql = 'SELECT answers.questions_id, answers.id as answers_id, 
                        count(records.id) as amount, 
                        sum(records.final) as positive
                FROM answers 
                left join records_answers on records_answers.answers_id = answers.id
                left join records on records.id = records_answers.records_id
                group by answers.id;';
        // get rows
        $rows = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
        $sql2 = 'select count(id) as total, sum(final) as positives
					 from records;';
        $row = $conn->query($sql2)->fetch_all(MYSQLI_ASSOC);

        $highestId = 0;
        $currentQuestions = [];
        $length = count($rows)-1;

        foreach ($rows as $key=>$question) {
            if (($question['amount']
                && !empty($currentQuestions)
                && $currentQuestions['questions_id'] != $question['questions_id']
            ) || $lastRow=($key === $length)) {
                if ($lastRow) {
                    $currentQuestions['answers'][$key]['sum'] = $question['amount'];
                    $currentQuestions['answers'][$key]['p'] = $question['positive'];
                }
                $gain = round($this->gain($currentQuestions,
                            $row[0]['total'],
                            $row[0]['positives']
                            ),
                3
                );
                $highestId = $highestId > $gain ? $highestId : $currentQuestions['questions_id'];
                unset($currentQuestions['answers']);
                $currentQuestions = [];
                var_dump('<br>'.$gain.'<br>');
            }

            if (empty($currentQuestions)) {
                $currentQuestions['questions_id'] = $question['questions_id'];
            }

            $currentQuestions['answers'][$key]['sum'] = $question['amount'];
            $currentQuestions['answers'][$key]['p'] = $question['positive'];
        }

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
        if($sum == $p) {
            return 0;
        }
        return floatval(( (-$p/$sum ) * log(($p/$sum),2) ) - ( (($sum - $p)/$sum) * log(($sum - $p)/$sum,2) ));
    }

    public function iCount($sum, $totalSum) {
        return floatval($sum/$totalSum);
    }



    public function nextQuestion($currentAnswer){
        $cookies = $_COOKIE[self::ANSWERS_COOKIE_NAME] ?? [];

        $cookies[] = $currentAnswer;
        $this->saveCookie(self::ANSWERS_COOKIE_NAME, $cookies);

        //Todo::logic of getting next question
    }

    public function saveCookie($cookie_name, $cookie_value) {
        //save data in the cookie during 1 day
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
    }

    public function save($final)
    {
        $answers = $_COOKIE[self::ANSWERS_COOKIE_NAME] ?? [];
        if (isset($answers)) {
            $Dbobj = new DbConnection();
            $conn = $Dbobj->getdbconnect();
            $sql = "INSERT INTO records (final) VALUES ('" . $final . "')";
            //check if there any errors in inputting first table (products)
            if (mysqli_query($conn, $sql) == TRUE) {
                $record_id = mysqli_insert_id($conn);

                foreach ($answers as $answer_id) {
                    $sql2 = "INSERT INTO attributes (records_id, answers_id) VALUES ({$record_id},'{$answer_id}')";

                    if (mysqli_query($conn, $sql2) == TRUE) {

                        //return no errors
                        return false;
                    }
                }
            }
        }
        return [];
    }

}