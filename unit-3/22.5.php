<?php
// Open a file for reading and writing
$file = 'file.txt';
$handle = fopen($file, 'r+');

// Check if the file was opened successfully
if ($handle === false) {
    echo "Error opening file: $file";
    exit;
}

// Write some content to the file
$content = "This is a line of text.\nAnd another line.\n";
fwrite($handle, $content);

// Set the file pointer to the beginning of the file
rewind($handle);

// Read the entire contents of the file
echo "Contents of the file:\n";
while (!feof($handle)) {
    echo fgets($handle);
}
echo "\n";

// Move the file pointer to a specific position
$position = 10;
fseek($handle, $position);

// Read from the new position
echo "Reading from position $position:\n";
while (!feof($handle)) {
    echo fgets($handle);
}
echo "\n";

// Move the file pointer relative to the current position
$offset = -5;
fseek($handle, $offset, SEEK_CUR);

// Read from the new position
echo "Reading from the offset $offset:\n";
while (!feof($handle)) {
    echo fgets($handle);
}

// Close the file
fclose($handle);
?>