
<?php
    $email; $comment; $captcha;

    if(isset($_POST['username']))
        $username=$_POST['username'];
    if(isset($_POST['password']))
        $password=$_POST['password'];
    if(isset($_POST['g-recaptcha-response']))
        $captcha=$_POST['g-recaptcha-response'];

    if(!$captcha){
        echo '<h2>Please check the the captcha form.</h2>';
        exit;
    }

    $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcFdOMbAAAAABVlj4_7eGdQ2Ha_3vHayE2YMoGP&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
    var_dump($response['success']);

?>
