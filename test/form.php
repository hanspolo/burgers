<?php

$f3=require('lib/base.php');
$f3->set("AUTOLOAD", "../lib");

class MyTestSqlMapper extends SqlMapper
{
  function __construct()
  {
    parent::__construct(new DB\SQL("sqlite:/tmp/test.sqlite"), "MyTest");
    $this->properties = array(
      "mybool" => array(
        "type" => "Boolean",
      ),
      "myemail" => array(
        "type" => "Email",
      ),
      "myfloat" => array(
        "type" => "Float"
      ),
      "myint" => array(
        "type" => "Integer",
      ),
      "mynumeric" => array(
        "type" => "Numeric",
      ),
      "mytext" => array(
        "type" => "Text",
      ),
    );
  }
}

$test=new Test;
$instance=new MyTestSqlMapper;
$form=new Form($instance);

try {
  echo $form->render();
} catch (Exception $e) {
  echo $e->getTraceAsString();
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
