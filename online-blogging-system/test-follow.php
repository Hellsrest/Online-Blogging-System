<?php
include 'test-header.php';
//session_start();
//o for follower 1 for following
?>
<?php
if (array_key_exists('id', $_GET) && array_key_exists('f', $_GET)) {
    $id = $_GET['id'];
    $f = $_GET['f'];
    $conn = new mysqli('localhost:3307', 'root', '', 'test-database');
    if ($conn->error) {
        echo ('error');
    }
    if ($f == 0) {
        $sql = "select * from follower f join account a on f.sender=a.uid where f.receiver='$id' ";
    } else if ($f == 1) {
        $sql = "select * from follower f join account a on f.receiver=a.uid where f.sender='$id'";
        
    } else {
        echo "page error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\follow.css">
</head>

<body>
    <?php
    $r = $conn->query($sql);
    if ($r->num_rows > 0) {
        while ($row = $r->fetch_assoc()) { ?>
            <div class="mainimage">
                <?php echo '<img src="' . $row['ppic'] . '" alt="Image">'; ?>
            </div>

            <div id="mainuser"><a href="test-account.php?id=<?php echo $row['uid']?>">
                <?php echo $row['username']; ?>
                </a>
            </div>

            <div id="mainbio">
                <?php echo $row['email'];; ?>
            </div>

            <div id="mainemail">
                <?php echo $row['bio'];; ?>
            </div>

   
        <?php } } ?>

 

    </div>
</body>

</html>