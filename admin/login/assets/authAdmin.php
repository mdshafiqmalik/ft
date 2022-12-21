<?php
class AuthenticateAdmin
{

  private $DB;
  public $VALID_ADMIN;

  function __construct()
  {

    $DB_CONNECT = new Database();
    $AUTH = new Auth();
    $this->DB =  $DB_CONNECT->DBConnection();

  }

  // Validate admin from admin login page
  public function loginAdminAuthenticate()
  {
    // Check Admin invitation
    // Checking invite code in link
    if (isset($_GET['inviteCode'])) {
      if (!empty($_GET['inviteCode'])) {
        //Validating invite code
        if ($this->validateInviteCode($_GET['inviteCode'])) {
          $GLOBALS['inviteIdFound'] = "Admin Invitation Found";
          setcookie("DID",$_GET["inviteCode"], time()+(86400*365), '/');
          setcookie("inviteCodeError","", time()-3600, '/');
          $this->VALID_ADMIN = true;
        }else {
          setcookie("inviteCodeError","Invalid ID found", time()+1000, '/');
          unset($GLOBALS['inviteIdFound']);
          $this->VALID_ADMIN = false;
        }
      }else {
        setcookie("inviteCodeError","Empty invitation ID", time()+1000, '/');
        unset($GLOBALS['inviteIdFound']);
        $this->VALID_ADMIN = false;
      }

      //Checking device code in cookie
    }elseif (isset($_COOKIE['DID'])) {
      if (!empty($_COOKIE['DID'])) {
        //Validating device code
          if ($this->validateDID($_COOKIE['DID'])) {
            $GLOBALS['inviteIdFound'] = "Registered Device Found";
            setcookie("inviteCodeError",false, time()-3600, '/');
            $this->VALID_ADMIN = true;
          }else {
            setcookie("inviteCodeError","Invalid ID found", time()+1000, '/');
            unset($GLOBALS['inviteIdFound']);
            $this->VALID_ADMIN = false;
          }
      }else {
        setcookie("inviteCodeError","Empty device ID found", time()+1000, '/');
        unset($GLOBALS['inviteIdFound']);
        $this->VALID_ADMIN = false;
      }
    }else if(DID_DISABLED){
      // $GLOBALS['inviteIdFound'] = "Logging Without Device ID";
      setcookie("inviteIdFound","Logging Without Device ID", time()+3600, '/');
      $this->VALID_ADMIN = true;
    }else{
      setcookie("inviteCodeError","No Admin Invite or Admin ID found", time()+1000, '/');
      unset($GLOBALS['inviteIdFound']);
      $this->VALID_ADMIN = false;
    }
  }


  public function adminLogStatus()
  {
    if (isset($_SESSION['adminLoginStatus']) && !empty($_SESSION['adminLoginStatus']) && $_SESSION['adminLoginStatus']) {

    }else {
      $return = false;
    }
    return $return;
  }

  // Validate eccrypted Invite code
  public function validateInviteCode($data){
    $decryptID = $this->AUTH->decrypt($data);
    $sql = "SELECT deviceID, linkStatus FROM deviceManager WHERE deviceID = '$decryptID'";
    $result = mysqli_query($this->DB, $sql);
    if ($row = $result->fetch_assoc()) {
      if ($row['deviceID'] = $decryptID) {
        if ((boolean)$row['linkStatus']) {
          $return = true;
          $this->VALID_ADMIN = true;
        }else {
          $return = false;
        }
      }else {
        $return = false;
        setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
        unset($GLOBALS['inviteIdFound']);
        $this->VALID_ADMIN = false;
      }
    }else {
      $return = false;
      setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
      unset($GLOBALS['inviteIdFound']);
      $this->VALID_ADMIN = false;
    }
    return $return;
  }

  // Validate Device ID
  public function validateDID($data){
    $decryptID = $this->AUTH->decrypt($data);
    $sql = "SELECT deviceID, deviceStatus FROM deviceManager WHERE deviceID = '$decryptID'";
    $result = mysqli_query($this->DB, $sql);
    if ($row = $result->fetch_assoc()) {
      if ($row['deviceID'] == $decryptID) {
        if ((boolean)$row['deviceStatus']) {
          $return = true;
          $this->VALID_ADMIN = true;
        }else {
          $return = false;
          setcookie("inviteCodeError","Device is blocked/banned", time()+10, '/');
          unset($GLOBALS['inviteIdFound']);
          $this->VALID_ADMIN = false;
        }
      }else {
        $return = false;
        setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
        unset($GLOBALS['inviteIdFound']);
        $this->VALID_ADMIN = false;

      }
    }else {
      $return = false;
      setcookie("inviteCodeError","Invalid Invitation Code or device ID", time()+10, '/');
      unset($GLOBALS['inviteIdFound']);
      $this->VALID_ADMIN = false;
    }
    return $return;
  }
}
 ?>
