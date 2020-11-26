<?php

//include_once '../classes/DbConnection.php';

include_once '../classes/questions.php';

//add header
include('shared/_header.php');
////new object of the Product class
//$gateway = new DbConnection();
//if (isset($_POST["checkboxvar"])) {
//    $gateway->deleteProducts($_POST["checkboxvar"]);
//    unset($_POST["checkboxvar"]);
//}
////get all product from db
//$products = $gateway->showProduct();
$gateway = new Questions();
$errorMessage = [];
if (isset($_POST["checkboxvar"])) {
    $gateway->setDeleteIds($_POST["checkboxvar"]);
    $response = $gateway->deleteProducts();
    if (!is_array($response)) {
        unset($_POST["checkboxvar"]);
    } else {
        $errorMessage = $response;
    }
}
$gateway->show();

?>
<html>
  <h1>ID3 ALGORITHM DEMO</h1>


      <div class="quiz-container">
        <div id="quiz">
          <form method="post" action ="">

            <br><br>

            <label class="question"> Why do you want to go to a theatre? </label>
            <br><br>
            <input type="radio" id="entertainment" name="purpose" value="entertainment">
            <label for="entertainment">Entertainment</label><br><br>
            <input type="radio" id="message" name="purpose" value="message">
            <label for="message">Message</label><br><br>

            <input type="radio" name="purpose" value="other">
            <label for="other">Other</label><br><br>
            <input style="display:none;" type="text" name="otherAnswer" id="otherAnswer"/>

            <br><br>
            <button id="submit">Submit Quiz</button>
          </form>
        </div>
      </div>
  </html>
}

  <script>
      $("input[type='radio']").change(function(){

          if($(this).val()=="other"){
              $("#otherAnswer").show();
          }
          else{
                 $("#otherAnswer").hide();
          }
        });
  </script>


<?php include('shared/_footer.php'); ?>
