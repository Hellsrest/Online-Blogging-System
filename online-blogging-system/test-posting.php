<?php
include 'test-header.php';
//session_start();
date_default_timezone_set('UTC');

//to upload image
if (isset($_POST['submitblog'])) {
    $title = $_POST['title'];
    $dtext = $_POST['display-text'];
    $atext = $_POST['hiddentextfield'];
    $pid = $_SESSION['id'];



    $status = "normal";
    $targetdir = "pimgs/"; 
    $targetfile = $targetdir . basename($_FILES["image"]["name"]);
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    $title = $conn->real_escape_string($title);
    $dtext = $conn->real_escape_string($dtext);
    $atext = $conn->real_escape_string($atext);
    $pid = $conn->real_escape_string($pid);
    $targetfile = $conn->real_escape_string($targetfile);
    $status = $conn->real_escape_string($status);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetfile)) {
            $sql="insert into posts values (0,'$title','$dtext',NOW(),'$atext','$pid',0,0,'$targetfile',0,'$status')";
            $r=$conn->query($sql);
            if ($r) {
                echo "Post submitted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }

        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "No image file uploaded or file upload error.";
    }
    $conn->close();
} else {
    echo "Form not submitted.";
}

?>


<html>

<head>
    <title>Verse: A Modern Blogging Platform</title>
    <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
    <link rel="stylesheet" href="css\posting.css">
</head>
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

<body>
    <div id="all-container">
        <form action="test-posting.php" method="POST" id="postform" enctype="multipart/form-data">
            <input type="text" name="title" id="titlefield" placeholder="Enter Title Here" required>
            <div id="titlecount"></div>

            <div id="imagecontainer">
                <input type="file" id="fileInput" accept="image/*">
            </div>

            <div id="fileupload">
                <input type="file" name="image" id="hello" required>
            </div>

            <input type="text" id="display-text" name="display-text" placeholder="Enter Placeholder Here" required>

            <div class="editor-container">
                <input type="hidden" name="hiddentextfield" id="hiddentextfield">
                <div class="toolbar">
                    <button id="boldButton" type="button"><b>B</b></button>
                    <button id="italicButton" type="button"><i>I</i></button>
                    <button id="strikeButton" type="button"><s>S</s></button>
                    <button id="leftAlignButton" type="button">Left Align</button>
                    <button id="rightAlignButton" type="button">Right Align</button>
                </div>
                <div id="editor" contenteditable="true"></div>
            </div>

            <input type="submit" name="submitblog" value="Post" onclick="submittohidden()">
        </form>
    </div>


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