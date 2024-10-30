<?php

require_once 'lib-sso.php';

$cid = $_SESSION[SESSION_SSO_KEY];
$ssoResult = RetrieveSSOLoginInfos(API_KEY, $cid);

if ($ssoResult->IsSuccess()) {
    //TODO Auth user in your app (select * from users where email=$ssolResult->email ...) and redirect to your favourite homepage
    //If you passed custom parameters, you can get them here $_GET["homepage"]...
    // $email = $ssoResult->email;


    $email = $ssoResult->email;

    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $email;
    $_SESSION['userid'] = 1;
    $_SESSION['userrole'] = 2;

    header('Location: ../../../');

}
