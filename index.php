<?php

require 'Classes/Headers.php';
require 'vendor/autoload.php';


use Classes\LoginClass;
use Classes\AccountClass;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginAccount = new LoginClass;
    $loginAccount->loginAccount();
    $addAccount = new AccountClass;
    $addAccount->addAccount();
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $getAccount = new AccountClass;
    $getAccount->getAccount();
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $delAccount = new AccountClass;
    $delAccount->deleteAccount();
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $updateAccount = new AccountClass;
    $updateAccount->updateAccount();
}


?>