<!-- 23. Including and uploading files
a. Write programs to demonstrate the use of include (), require(), include_once() and 
require_once() functions. -->
<?php
include 'sum.php';
echo "Addition is ".sum(1,2);

require 'subtract.php';
echo "<br> subtraction is ".sub(3,4);

include_once 'sum.php';
echo "<br> Addition is ".sum(5,6);

require_once 'subtract.php';
echo "<br> subtraction is ".sub(17,8);

?>

