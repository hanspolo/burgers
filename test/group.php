<?php

$f3=require("lib/base.php");
$f3->set("AUTOLOAD", "../lib");

$test = new Test;
$group = new Group(new DB\SQL("sqlite:/tmp/test.sqlite"));

$group->name = "My Group";
$group->save();

$test->expect($group->_id > 0, "Group was saved");
$group->load(array("id = ?", $group->_id));

$test->expect($group->erase(), "Group was deleted");

foreach ($test->results() as $result) {
  echo $result['text']."\t";
  if ($result['status'])
    echo 'Pass';
  else
    echo 'Fail ('.$result['source'].')';
  echo "\n";
}
