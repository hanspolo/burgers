<?php


$f3=require('lib/base.php');
$f3->set("AUTOLOAD", "../lib");

class MyTestSqlMapper extends SqlMapper
{
  function __construct()
  {
    parent::__construct(new DB\SQL("sqlite:/tmp/test.sqlite"), "MyTest");
    $this->properties = array(
      "myint" => array(
        "type" => "Integer",
      ),
      "mybool" => array(
        "type" => "Boolean",
      ),
    );
  }
}

$test=new Test;
$instance=new MyTestSqlMapper;


$test->expect(true, "Well, true is true");
try {
  $instance->myint = 1;
  $test->expect(true, "Can set 1 to an int field");
} catch (Exception $e) {
  echo $e->getTraceAsString();
  $test->expect(false, "Can set 1 to an int field");
}
try {
  $instance->myint = 0;
  $test->expect(true, "Can set 0 to an int field");
} catch (Exception $e) {
  echo $e->getMessage();
  $test->expect(false, "Can set 0 to an int field");
}

try {
  $instance->myint = "abc";
  $test->expect(false, "Can't set 'abc' to an int field");
} catch (Exception $e) {
  $test->expect(true, "Can't set 'abc' to an int field");
}

// Display the results; not MVC but let's keep it simple
foreach ($test->results() as $result) {
  echo $result['text']."\t";
  if ($result['status'])
    echo 'Pass';
  else
    echo 'Fail ('.$result['source'].')';
  echo "\n";
}
