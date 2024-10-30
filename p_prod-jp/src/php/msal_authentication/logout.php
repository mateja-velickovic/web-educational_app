<?php

//If you want to invalidate global SSO token, Call this page after your internal logout stuff
//adapt URL_AFTER_LOGOUT to your needs...

require_once 'lib-sso.php';

$URL_AFTER_LOGOUT = 'https://'.$_SERVER['SERVER_NAME'].'/';
header('Location: '.SSO_PORTAL."bridge/logout?redirectUri=$URL_AFTER_LOGOUT");
