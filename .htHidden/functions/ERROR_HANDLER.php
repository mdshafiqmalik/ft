<?php
class HandleError
{
  private $ERROR_LOCATION;
  private $ERROR_MESSAGE;

  function __construct($ERROR_MESSAGE)
  {
    $this->ERROR_MESSAGE = $ERROR_MESSAGE;
    $this->ERROR_LOCATION = "../errors/index.php";
    $this->Redirect();
  }

  private function Redirect(){
    if (REDIRECT_ON_ERROR) {
      $LOC = $this->ERROR_LOCATION;
      $message = $this->ERROR_MESSAGE;
      setcookie("errorMessage", $message, time()+86400, '/');
      header("Location:$LOC");
      exit;
    }else {
      setcookie("errorMessage", false, time()-86400, '/');
    }
  }

}

 ?>
