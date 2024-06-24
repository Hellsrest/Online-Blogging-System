<?php
$str = "Hello Everyone.hello World. The string heLLo is the pattern";
$pattern = "/hello/i";
echo "The original string is=".$str."<br/>";
echo "Using preg_match function=".preg_match($pattern, $str)."<br/>";
echo "Using preg_match_all function=".preg_match_all($pattern, $str)."<br/>";
echo "Using preg_replace function=".preg_replace($pattern, "hi", $str)."<br/>";
?>
