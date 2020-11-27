<?php
// Starting session
session_start();
//include_once '../classes/DbConnection.php';

include_once '../classes/questions.php';

//add header
include('shared/_header.php');
$questionsObj = new Questions();

if (isset($_POST["new"])) {
    unset($_POST['answer']);
    unset($_POST['new']);
    unset($_POST['final_answer']);
    unset($_POST['question_id']);
    unset($_SESSION['final_question']);
    $questionsObj->deleteSession();
}

    if (isset($_POST["answer"])) {
//        var_dump('post--->');
//        var_dump('<pre>');
//        var_dump($_POST["answer"]);
//
//        var_dump('</pre>');
        $questionsObj->saveAnsweredQuestion($_POST["answer"]);
        unset($_POST['answer']);
    }

if (!$questionsObj->needToInsertData()) {
    $questions = $questionsObj->id3();
} else {
    $questions =$questionsObj->ordinaryQuestionsFlow();
}
//var_dump(!$questionsObj->needToInsertData());
        var_dump('<pre>');
        var_dump($questions);

        var_dump('</pre>');
?>
<html>
  <h1>ID3 ALGORITHM DEMO</h1>
  <form method="post">
  <button name="new" id="submit">start new</button>
  </form>
      <div class="quiz-container">
        <div id="quiz">
          <form method="post">
              <?php
              if (isset($_SESSION['final_question'])) {
                  ?>
                  <br><br>

                  <label class="question">Do you want to go to the cinema?</label>
                  <br><br>
                  <input type="radio" name="final_answer" value="true">
                  <label for="other">True</label><br><br>

                  <input type="radio" name="final_answer" value="false">
                  <label for="other">False</label><br><br>
                  <button id="submit">Answer</button>
                  <?php
              }elseif (isset($questions) && is_array($questions)) {
                  ?>
            <br><br>

            <label class="question"> <?=$questions[0]['question'] ?></label>
            <br><br>
                  <input hidden name="question_id" value="<?=$questions[0]['id'] ?>">
            <?php foreach ($questions as $question) { ?>
            <input type="radio" id="entertainment-<?= $question['answers_id'];?>" name="answer[<?=$question['id'];?>]" value="<?=$question['answers_id'];?>">
            <label for="entertainment-<?= $question['answers_id'];?>"><?=$question['answer'];?></label><br><br>
            <?php } ?>
                <?php if($questionsObj->needToInsertData()) { ?>
                  <input type="radio" name="answer[<?=$question['id'];?>]" value="0">
                  <label for="other">Other</label><br><br>
                  <input style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/>
                  <?php } ?>
            <br><br>
            <button id="submit">Next Question</button>
              <?php } elseif (is_numeric($questions)) {
                  $questionsObj->deleteSession();
                  unset($_POST['answer']);
               ?>
                  <label class="question"> <?=$questions ? $questionsObj::FINAL_TRUE : $questionsObj::FINAL_FALSE?></label>
                  <br><br>
                  <button id="submit">Start new</button>
              <?php
              } else {
                  echo "Smth wrong!";
              }?>
          </form>
        </div>
      </div>
  </html>

  <script>
      $("input[type='radio']").change(function(){

          if($(this).val()=="0"){
              $("#otherAnswer").show();
          }
          else{
                 $("#otherAnswer").hide();
          }
        });
  </script>


<?php include('shared/_footer.php'); ?>
