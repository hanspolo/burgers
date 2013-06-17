<?php

$f3=require("lib/base.php");
$f3->set("AUTOLOAD", "../lib");

$test = new Test;

$user = new User(new DB\SQL("sqlite:/tmp/test.sqlite"));

$user->password = "abc";
$test->expect($user->password != "abc", "Password is gonna be encrypted");

$user->name = "Hanspolo";
$user->email = "hanspolo@github.io";
$user->save();

$test->expect($user->_id > 0, "User was saved");
$user->load(array("id = ?", $user->_id));
 
$test->expect($user->checkLogin("hanspolo@github.io", "abc"), "Password can be verified");
$test->expect(!$user->checkLogin("hanspolo@github.io", "jklö"), "Wrong Password detected");
$test->expect(!$user->checkLogin("karl@bavaria.de", "abc"), "Wrong Email detected");

$test->expect($user->erase(), "User was deleted");


foreach ($test->results() as $result) {
  echo $result['text']."\t";
  if ($result['status'])
    echo 'Pass';
  else
    echo 'Fail ('.$result['source'].')';
  echo "\n";
}
