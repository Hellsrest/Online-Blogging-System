$(document).ready(function() {
    $(".reply-btn").click(function() {
        var commentid = $(this).data("commentid");
        var postid = $(this).data("postid");
        var userid = $(this).data("userid");
        $("#reply-form").show();
        $("#submit-reply").data("commentid", commentid);
        $("#submit-reply").data("postid", postid);
        $("#submit-reply").data("userid", userid);
    });
    
    $("#submit-reply").click(function() {
        var commentid = $(this).data("commentid");
        var postid = $(this).data("postid");
        var userid = $(this).data("userid");
        var reply = $("#reply-input").val();
    
        if (reply.trim() !== "") {
            $.ajax({
                url: "testing/two.php",
                method: "POST",
                data: { commentid: commentid, reply: reply, postid: postid, userid: userid },
                success: function(response) {
                    $("#reply-input").val("");
                    $("#reply-form").hide();
                    location.reload(); // Reload the page to display the new reply
                }
            });
        }
    });
    

    $(".edit-btn").click(function() {
        var commentid = $(this).data("commentid");
        console.log(commentid); // This will log the commentid value
        $(".edit-form").hide(); // Hide all edit forms
        $(this).next(".edit-form").show(); // Show the edit form next to the clicked button
        console.log("i am working"); // This will log a message to confirm the click event is working
    });

    $(".submit-edit").click(function() {
        var commentid = $(this).parent().data("commentid");
        var editedComment = $(this).siblings(".edit-input").val();
        console.log(commentid);
        console.log(editedComment);
        if (editedComment.trim() !== "") {
            $.ajax({
                url: "testing/four.php",
                method: "POST",
                data: { commentid: commentid, comment: editedComment },
                success: function(response) {
                    location.reload(); // Reload the page to display the edited comment
                }
            });
        }
    });
});