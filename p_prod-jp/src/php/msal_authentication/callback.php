<?php

require_once 'lib-sso.php';
include "login.php";

$cid = $_SESSION[SESSION_SSO_KEY];
$ssoResult = RetrieveSSOLoginInfos(API_KEY, $cid);

if ($ssoResult->IsSuccess()) {
    //TODO Auth user in your app (select * from users where email=$ssolResult->email ...) and redirect to your favourite homepage
    //If you passed custom parameters, you can get them here $_GET["homepage"]...

    $email = $ssoResult->email;

    InitiateUser($email);

    $userData = GetUserData($email);

    $_SESSION['loggedin'] = true;

    $_SESSION['userid'] = $userData['idUser'];
    $_SESSION['name'] = $userData['useName'];
    $_SESSION['surname'] = $userData['useSurname'];
    $_SESSION['userrole'] = $userData['fkRole'];

    header('Location: ../../../');

}
