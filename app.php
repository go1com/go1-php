<?php

require_once "vendor/autoload.php";

define('CLIENT_ID', '');
define('SECRET', '');
define('ENDPOINT', 'https://api.go1.com/v1');

$go1 = new \go1\api\GO1(['endpoint' => ENDPOINT, 'client_id' => CLIENT_ID, 'client_secret' => SECRET]);
$go1->authenticate();
$users = $go1->getUsers();
$learningObjects = $go1->getLearningObject();
$enrolments = $go1->getEnrollments();
$webhooks = $go1->getWebhooks();

var_dump($users, $learningObjects, $enrolments, $webhooks);