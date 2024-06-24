<!DOCTYPE html>
<html lang="en">

<?php
include 'test-header.php';
?>

<head>
  <title>Verse: Register to the Site</title>
  <link rel="shortcut icon" type="imgs/png" href="imgs/verse-small.png">
  <link rel="stylesheet" href="css\messaging.css">
</head>
<?php
date_default_timezone_set('UTC');
$uid = $_SESSION['id'];
echo '<script>';
echo 'var uid = ' . json_encode($_SESSION['id']) . ';';
echo 'var accname = ' . json_encode($_SESSION['username']) . ';';
echo 'var accppic = ' . json_encode($_SESSION['ppic']) . ';';
echo '</script>';
$maxCount = 100;

// Displaying all users friends
$conn = new mysqli("localhost:3307", "root", "", "test-database");
$sql = "select f.*,a.* from `follower` f join account a on a.uid=f.receiver where sender='$uid'";
$sql1 = "select * from `messages` where sender='$uid' and rid=''";
$r = $conn->query($sql);
$row = $r->fetch_assoc();
$r->data_seek(0);
echo ("<br/>");
$count = 0;
while ($row = $r->fetch_assoc()) {
  $count++;
  // Shows friends id in clickable button form
  echo '<div id="friend-conatiner">';

  echo '<div id="one-friend">';
  echo '<img src=' . $row['ppic'] . ' class="friend"></img>';

  echo '<div class="friend-username">';
  echo '<button type="submit" name="person" id="followed' . $count . '" value="' . $row['receiver'] . '">' . $row['username'] . '</button>';
  echo '</div>';

  echo '<div id="recent-msg">';
  echo $row['bio'];
  echo '</div>';

  echo '</div>';

  echo '</div>';
}

if (isset($_POST['send'])) {
  $msg = $_POST['msg'];
  $rid = $_POST['rid'];
  $sid = $_SESSION['id'];
  $conn = new mysqli("localhost:3307", "root", "", "test-database");
  if ($conn->error) {
    echo ("No connection :(");
  }
  $sql = "insert into `messages` VALUES (0, '$sid', '$rid', '$msg',DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s'))";
  $r = $conn->query($sql);
  if ($r) {
    echo ("messege added succesfully");
    header("Location: test-messaging.php");
  } else {
    echo ("messege not added succesfully");
    header("Location: test-messaging.php");
  }
}
?>

<body>
  <div id="msgcontainer"></div>
  <div id="other"></div>
  <div id="self"></div>
  <div id="msgsend"></div>
</body>

</html>

<script>
  console.log("hellp");

</script>

<script>
  var maxCount = <?php echo $maxCount; ?>;
  console.log(uid);
  console.log(accname);
  var x;
  for (var i = 1; i <= maxCount; i++) {
    var id = 'followed' + i;
    var button = document.getElementById(id);
    var container = document.getElementById("msgsend");
    if (button) {
      button.addEventListener('click', (function (value) {
        return function () {

          x = value; // Extract the numeric part from the id
          console.log('Value of clicked button: ' + x);
          fetchmsgs(uid, x);

          var recentmsg = document.getElementById("recent-msg");
          recentmsg.setAttribute("data-value", x);

          var existingForm = document.getElementById("dynamic-form");
          if (existingForm) {
            container.removeChild(existingForm);
          }
          var form = document.createElement("form");
          form.setAttribute("id", "dynamic-form");
          form.setAttribute("action", "test-messaging.php");
          form.setAttribute("method", "post");

          var ridInput = document.createElement("input");
          ridInput.setAttribute("type", "hidden");
          ridInput.setAttribute("name", "rid");
          ridInput.setAttribute("value", x);
          form.appendChild(ridInput);

          var msgInput = document.createElement("input");
          msgInput.setAttribute("type", "text");
          msgInput.setAttribute("name", "msg");
          msgInput.setAttribute("placeholder", "Enter message here");
          form.appendChild(msgInput);

          var submitButton = document.createElement("input");
          submitButton.setAttribute("type", "submit");
          submitButton.setAttribute("name", "send");
          form.appendChild(submitButton);

          var msgContainer = document.createElement("div");
          msgContainer.setAttribute("id", "msg-container");
          form.appendChild(msgContainer);

          container.appendChild(form);
        };
      })(button.value)); // Pass id to the closure
    }
  }

  function updatemsgs(messages, userid, rid) {
  var other = document.getElementById('other');
  var self = document.getElementById('self');
  other.innerHTML = '';
  self.innerHTML = '';

  if (Array.isArray(messages)) {
    if (messages.length === 0) {
      msgcont.textContent = 'No messages found.';
    } else {
      messages.forEach(message => {
        if ((message.sid == userid && message.rid == rid) || (message.sid == rid && message.rid == userid)) {
          const msgele = document.createElement('div');
          msgele.textContent = `${message.username} - ${message.sid} - ${message.rid} - ${message.message}- ${message.date}`;

          if (message.sid == userid) {
            self.appendChild(msgele);
          } else {
            other.appendChild(msgele);
          }
        }
      });
    }
  }
}


  function fetchmsgs(user_id, rid) {
    fetch(`test-json.php?user_id=${user_id}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(msgs => {
        updatemsgs(msgs, user_id, rid);
      })
      .catch(error => {
        console.error('Error fetching messages:', error);
      });
  }

  setInterval(() => fetchmsgs(uid, x), 5000);
  fetchmsgs(uid, x);
</script>