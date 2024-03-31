<?php
    
    require '../Database/database.php';

    if (!$con) {
        die('error in con' . mysqli_error($con));
    }

    $id = $_GET['id'];



    $delete_feedback = "DELETE FROM pr_segment_feedback WHERE pr_segment_feedback_id = $id";

    if (mysqli_query($con, $delete_feedback)) {
        echo '<script>alert("Feedback Deleted Successfully");</script>';
        header('location: feedback_insert.php');
    } else {
        echo mysqli_error($con);
    }
?>
