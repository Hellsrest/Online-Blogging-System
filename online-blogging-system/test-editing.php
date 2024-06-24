<?php
include 'test-header.php';
//session_start();
?>

<?php
//to display retrived data from the database
if (array_key_exists('id', $_GET)) {
    $id = $_GET['id'];
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $sql = "select * from posts where id ='$id'";
    $r = $conn->query($sql);
    $row = $r->fetch_assoc();
    $id = ($row['id']);
    $title = htmlspecialchars($row['Title'], ENT_QUOTES, 'UTF-8');
    $display = htmlspecialchars($row['display-text'], ENT_QUOTES, 'UTF-8');
    $actual = ($row['post']);
    $img = ($row['image']);
    echo '<script>';
    echo 'var imgsg = ' . json_encode($row['image']) . ';';
    echo '</script>';
}

if (isset($_POST['editblog'])) {
    $id = $_POST['postid'];
    $title = $_POST['title'];
    $dtext = $_POST['display-text'];
    $atext = $_POST['hiddentextfield'];
    $pid = $_SESSION['id'];
    $status = "normal";
    $targetdir = "pimgs/";
    $targetfile = $targetdir . basename($_FILES["image"]["name"]);
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetfile)) {
            $sql = "UPDATE posts SET Title = ?, `display-text` = ?, post = ?, image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $title, $dtext, $atext, $targetfile, $id);
            $r = $stmt->execute();
            if ($r) {
                echo "Post submitted successfully.";
                header("Location:test-display.php?page-nr=1");
            } else {
                echo "Error: " . $stmt->error;
                header("Location:test-display.php?page-nr=1");
            }
            $stmt->close();
        } else {
            echo "Error uploading the file.";
        }
    } else {
        $targetfile=$_POST['sameimg'];
        $sql = "UPDATE posts SET Title = ?, `display-text` = ?, post = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $dtext, $atext, $targetfile, $id);
        $r = $stmt->execute();
        if ($r) {
            echo "Post submitted successfully.";
            header("Location:test-display.php?page-nr=1");
        } else {
            echo "Error: " . $stmt->error;
            header("Location:test-display.php?page-nr=1");
        }
        $stmt->close();
    }
    $conn->close();
    header("Location:test-display.php?page-nr=1");

} 
?>

<html>

<head>
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <link rel="stylesheet" href="css\editing.css">
    <style>
        .editor-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .toolbar {
            margin-bottom: 10px;
        }

        .toolbar button {
            margin-right: 5px;
        }

        #editor {
            width: 90%;
            height: 200px;
            border: 1px solid #ccc;
            padding: 10px;
            overflow-y: auto;
        }
    </style>
</head>


<body>
    <div id="all-container">
        <form action="test-editing.php" method="POST" id="postform" enctype="multipart/form-data">
            <input type="text" name="postid" value="<?php echo $id?>" hidden >
            <input type="text" name="title" id="titlefield" placeholder="Enter Title Here" value="<?php echo $title ?>"
                required>
            <div id="titlecount"></div>



            <div id="imagecontainer">
                <input type="file" id="fileInput" accept="image/*">
                <img src="<?php echo $img ?>">
            </div>
            <input type="hidden" name="sameimg" value="<?php echo $img ?>">
            <div id="fileupload">

                <input type="file" name="image" id="hello" value="<?php echo $img ?>">
            </div>

            <input type="text" id="display-text" name="display-text" placeholder="Enter Placeholder Here"
                value="<?php echo $display ?>">

            <div class="editor-container">
                <input type="hidden" name="hiddentextfield" id="hiddentextfield">
                <div class="toolbar">
                    <button id="boldButton" type="button"><b>B</b></button>
                    <button id="italicButton" type="button"><i>I</i></button>
                    <button id="strikeButton" type="button"><s>S</s></button>
                    <button id="leftAlignButton" type="button">Left Align</button>
                    <button id="rightAlignButton" type="button">Right Align</button>
                </div>
                <div id="editor" contenteditable="true" value=<?php echo htmlspecialchars($actual)?>></div>
            </div>

            <input type="submit" name="editblog" value="edit" onclick="submittohidden()">
        </form>
    </div>

    <script>
    var actualValue = <?php echo json_encode($actual); ?>;
    document.getElementById('editor').innerHTML = actualValue;
</script>
    <script>

        
        //to send the content of the division to the hiddentextfield for submissions
        function submittohidden() {
            const editorContent = document.getElementById("editor").innerHTML;
            document.getElementById("hiddentextfield").value = editorContent;
        }

        //to display image in the division
        document.getElementById('hello').addEventListener('change', function (event) {
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onload = function (event) {
                var imageUrl = event.target.result;
                var imageElement = document.createElement('img');
                imageElement.src = imageUrl;

                var imagecontainer = document.getElementById('imagecontainer');
                imagecontainer.innerHTML = '';
                imagecontainer.appendChild(imageElement);
            };

            reader.readAsDataURL(file);
        });

        // to count the number o f words in the title division
        document.getElementById("titlefield").addEventListener("input", function () {
            var titletext = this.value;
            var titleletter = titletext.trim().split('').length;
            var maxwords = 150;
            var titlecount = document.getElementById("titlecount");
            if (titleletter > maxwords) {
                this.value = this.value.split(/\s+/).slice(0, maxwords).join(" ");
                titleletter = maxWords;
            }
            document.getElementById("titlecount").textContent = titleletter + " / " + maxwords + " words";
        });
    </script>
    <script src="posting-buttons.js"></script>

</body>

</html>