<?php
if (isset($_POST['submitblog'])) {
    $title = $_POST['title'];
    $dtext = $_POST['display-text'];
    $atext = $_POST['hiddentextfield'];
    $pid = $_SESSION['id'];
    $status = "normal";

    // Directory to upload files
    $targetdir = "uploads/"; // Ensure this directory exists and is writable
    $targetfile = $targetdir . basename($_FILES["image"]["name"]);

    // Create database connection
    $conn = new mysqli("localhost:3307", "root", "", "test-database");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if an image file is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetfile)) {
            // Prepare an SQL statement to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO posts  VALUES (?, ?, NOW(), ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $title, $dtext, $atext, $pid, $targetfile, $status);

            // Execute the prepared statement
            if ($stmt->execute()) {
                echo "Post submitted successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "No image file uploaded or file upload error.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Form not submitted.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rich Text Editor</title>
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
            width: 100%;
            height: 200px;
            border: 1px solid #ccc;
            padding: 10px;
            overflow-y: auto;
        }
    </style>
</head>
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

            <input type="submit" name="submitblog" value="Post">
        </form>
    </div>

    <script>
        document.getElementById("boldButton").addEventListener("click", function() {
            document.execCommand('bold');
        });

        document.getElementById("italicButton").addEventListener("click", function() {
            document.execCommand('italic');
        });

        document.getElementById("strikeButton").addEventListener("click", function() {
            document.execCommand('strikeThrough');
        });

        document.getElementById("leftAlignButton").addEventListener("click", function() {
            document.execCommand('justifyLeft');
        });

        document.getElementById("rightAlignButton").addEventListener("click", function() {
            document.execCommand('justifyRight');
        });

        document.getElementById("postform").addEventListener("submit", function (e) {
            // Prevent the default form submission
            e.preventDefault();

            // Get the content of the editor div
            const editorContent = document.getElementById("editor").innerHTML;
            console.log('Editor content:', editorContent); // Debugging line

            // Set the value of the hidden input to the content of the editor div
            document.getElementById("hiddentextfield").value = editorContent;
            console.log('Hidden field value:', document.getElementById("hiddentextfield").value); // Debugging line

            // Allow some time for the hidden field to be updated before submitting
            setTimeout(() => {
                // Submit the form programmatically
                e.target.submit();
            }, 100); // 100 milliseconds delay
        });
    </script>
</body>
</html>
