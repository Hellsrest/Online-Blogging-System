<?php
if(isset($_POST['submit'])){
    require_once('TCPDF-main/tcpdf.php');

    // Create new PDF document
    $pdf = new TCPDF();
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('User Information');
    $pdf->SetHeaderData('', 0, '', '');
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 12);
    
    // Get form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    // HTML content
    $html = "
        <h1>User Information</h1>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Username:</strong> $username</p>
        <p><strong>Age:</strong> $age</p>
        <p><strong>Password:</strong> $password</p>
        <p><strong>Retype Password:</strong> $confirm</p>
    ";
    
    // Output HTML content as PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Close and output PDF document
    $pdf->Output('info.pdf', 'F');
    
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
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name"></input></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username"></input></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input type="text" name="age"></input></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="text" name="password"></input></td>
            </tr>
            <tr>
                <td>Retype Password</td>
                <td><input type="text" name="confirm"></input></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form> 
</body>
</html>