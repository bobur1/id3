<?php

include ('DbConnection.php');
class Questions
{

    const ANSWERS_COOKIE_NAME = 'answers';

    public function show()
    {
        $cookies = $_COOKIE[self::ANSWERS_COOKIE_NAME] ?? [];
        //db obkect
        $Dbobj = new DbConnection();
        $conn = $Dbobj->getdbconnect();

        $cookies = [1=>2]; //1=>1,2=>5
        $selectedRecords = [];

        if(!empty($cookies)) {
            foreach ($cookies as $answers_id) {
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
        }

        $sql = 'SELECT answers.questions_id, answers.id as answers_id, 
                        count(records.id) as amount, 
                        sum(records.final) as positive
                FROM (select * from answers ';
        if(!empty($cookies)) {
            $sql .= ' where answers.questions_id not in (' . implode(', ', array_keys($cookies)) . ')';
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
                var_dump('Yes');
                return 1;
            } elseif( $row[0]['positives'] == 0){
                var_dump('No');
                return 0;
            }
        }
//        var_dump($row);
//        die();

        $highestId = 0;
        $currentQuestions = [];
        $length = count($rows)-1;

        foreach ($rows as $key=>$question) {
            if (!empty($cookies) && in_array($question['questions_id'], array_keys($cookies))) {
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
                var_dump('<br>'.$gain.'<br>');
            }

            if (empty($currentQuestions)) {
                $currentQuestions['questions_id'] = $question['questions_id'];
            }

            $currentQuestions['answers'][$key]['sum'] = $question['amount'];
            $currentQuestions['answers'][$key]['p'] = $question['positive'];
        }
        var_dump('<br> highest'.$highestId.'<br>');
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