<?php

require_once 'lib-sso.php';

$cid = GenerateCorrelationId(API_KEY);

InitiateSSOLogin($cid, ['homepage' => 'home.php']/*Just an example, can be empty*/);
