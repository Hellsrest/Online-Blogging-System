<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
    <h2>Simple Calculator</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="num1">First Number:</label>
        <input type="text" name="num1" id="num1" required><br><br>

        <label for="num2">Second Number:</label>
        <input type="text" name="num2" id="num2" required><br><br>

        <label for="operator">Operator:</label>
        <select name="operator" id="operator">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
            <option value="%">%</option>
        </select><br><br>

        <input type="submit" name="submit" value="Calculate">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];
        $operator = $_POST["operator"];
        $result = null;

        switch ($operator) {
            case "+":
                $result = $num1 + $num2;
                break;
            case "-":
                $result = $num1 - $num2;
                break;
            case "*":
                $result = $num1 * $num2;
                break;
            case "/":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    echo "Error: Division by zero is not allowed.";
                }
                break;
            case "%":
                if ($num2 != 0) {
                    $result = $num1 % $num2;
                } else {
                    echo "Error: Modulus by zero is not allowed.";
                }
                break;
            default:
                echo "Invalid operator.";
        }

        if ($result !== null) {
            echo "<label>Result: $result</label>";
        }
    }
    ?>
</body>
</html>