<?php
if(isset($_POST['submit'])){
    $m=0;
    $num=$_POST['number'];
    if($num<0){
        echo("negetive number");
    }else{
        if($num%2==0){
            for($i=1;$i<=10;$i++){
                $m=$num*$i;
                echo($num."*".$i."=".$m."<br>");
            }
        }else{
            $ten=$num*10;
            for($i=$num;$i<=$ten;$i++){
                echo($i."<br>");
            }
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="numadd.php">
        <table>
            <tr>
                <td>Enter Number</td>
                <td><input type="number" name="number"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>