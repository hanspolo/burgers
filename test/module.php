<?php

$f3=require('lib/base.php');
$f3->set("AUTOLOAD", "../lib");

$test=new Test;
$module = new Module();

class MyTestModule extends AbstractModule
{
  public function execute()
  {
  }
}

class MyFalseTestModule
{
}

try {
  $module->execute("MyTestModule");
  $test->expect(true, "MyTestModule is executed.");
} catch (Exception $e) {
  $test->expect(false, "MyTestModule is executed.");
}

try {
  $module->execute("MyFalseTestModule");
  $test->expect(false, "MyFalseTestModule is not executed.");
} catch (Exception $e) {
  $test->expect(true, "MyFalseTestModule is not executed.");
}

try {
  $module->execute("MyNonExistingTestModule");
  $test->expect(false, "MyNonExistingTestModule is not executed.");
} catch (Exception $e) {
  $test->expect(true, "MyNonExistingTestModule is not executed.");
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
