<?php
// include '../secrets/encDec.php';
// include '../secrets/db.php';
// error_reporting(0);
class Name
{
  public $name = "Mohd Shafiq Malik";
  function __construct()
  {
    $this->name = "Mohd Shafiq Malik";
  }
}


/**
 *
 */
class Muslim extends Name
{

  function __construct()
  {
  }
}

$n = new Muslim();
echo $n->name;
?>
