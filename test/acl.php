<?php

$f3=require('lib/base.php');
$f3->set("AUTOLOAD", "../lib");

$test=new Test;
$instance = new ACL(new DB\SQL("sqlite:/tmp/test.sqlite"));
$acl = new ACL(new DB\SQL("sqlite:/tmp/test.sqlite"));

$instance->action = "Node";
$instance->rule = ACL_READ + ACL_EDIT;
$instance->groupId = 1;

$instance->save();

$test->expect($instance->_id > 0, "ACL was saved.");
$instance->load(array("id = ?", $instance->_id));

$test->expect($acl->check(1, "Node", ACL_READ), "Have the right to Read");
$test->expect($acl->check(1, "Node", ACL_EDIT), "Have the right to Edit");
$test->expect(!$acl->check(1, "Node", ACL_CREATE), "Have not the right to Create");
$test->expect(!$acl->check(1, "Node", ACL_DELETE), "Have not the right to Delete");

try {
  $acl->check(2, "Node", ACL_READ);
  $test->expect(false, "Get an Exception for asking a wrong groupId");
} catch (Exception $e) {
  $test->expect(true, "Get an Exception for asking a wrong groupId");
}

try {
  $acl->check(1, "Apples", ACL_READ);
  $test->expect(false, "Get an Exception for asking a wrong action");
} catch (Exception $e) {
  $test->expect(true, "Get an Exception for asking a wrong action");
}

$test->expect($instance->erase(), "ACL was deleted.");

// Display the results; not MVC but let's keep it simple
foreach ($test->results() as $result) {
  echo $result['text']."\t";
  if ($result['status'])
    echo 'Pass';
  else
    echo 'Fail ('.$result['source'].')';
  echo "\n";
}
