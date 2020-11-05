<?php 



$a = array();

$a[] = 1;
$a[] = "2";
$a[] = "3";

$b = array_filter($a, "is_string");

print_r($b);
