<?php 

    require '../Database/database.php';


    if (!$con) {
        die('error in db' . mysqli_error($con));
    }

    // Variables to store form data
    $segment_feedback_id = $segment_feedback_client = $segment_feedback_desc = $segment_feedback_status = '';


    // Fetch data for editing when the page loads
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $select_feedback = "SELECT * FROM pr_segment_feedback WHERE pr_segment_feedback_id = $id";
        $run = $con->query($select_feedback);
        if ($run->num_rows > 0) {
            $row                    = $run->fetch_assoc();
            $segment_feedback_client_id                  = $row['pr_segment_feedback_id'];
            $segment_feedback_client                     = $row['pr_segment_feedback_client'];
            $segment_feedback_desc                       = $row['pr_segment_feedback_desc'];
            $segment_feedback_status                     = $row['pr_segment_feedback_status'];
            
        }
    }


    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
            

                
            // Retrieve other form fields
            $segment_feedback_client                = $_POST['pr_segment_feedback_client'];
            $segment_feedback_desc                  = $_POST['pr_segment_feedback_desc'];
            $segment_feedback_status                = $_POST['pr_segment_feedback_status'];
            


            // Update data in the database
            $update_feedback = "UPDATE pr_segment_feedback SET 
                                        pr_segment_feedback_desc        = '$segment_feedback_desc', 
                                        pr_segment_feedback_status      = '$segment_feedback_status'
                                    WHERE pr_segment_feedback_client    = '$segment_feedback_client'";

            // Execute the SQL query
            if (mysqli_query($con, $update_feedback)) {
                echo '<script>alert("Feedback Updated Successfully");</script>';
                header('location: feedback_insert.php');
            } else {
                echo "Error updating record: " . mysqli_error($con);
            }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Feedback Update</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>
<body>
    <form id="feedback_form" method="post">
        <div class="wrapper">
        <input type="hidden" name="pr_segment_feedback_id" value="<?php echo $segment_feedback_client_id; ?>">
            <div class="form-row">
                <label for="pr_segment_feedback_client">Client: <?php echo $segment_feedback_client; ?></label>
                <input type="hidden" name="pr_segment_feedback_client" id="pr_segment_feedback_client" placeholder="Enter Client" value="<?php echo $segment_feedback_client; ?>"  required>
            </div>

            <div class="form-row">
                <label for="pr_segment_feedback_desc">Feedback</label>
                <textarea name="pr_segment_feedback_desc" id="pr_segment_feedback_desc" placeholder="Enter Feedback" required><?php echo $segment_feedback_desc; ?></textarea>
            </div>

            <div class="form-row">
                <label for="pr_segment_feedback_status">Status</label>
                <input type="number" name="pr_segment_feedback_status" id="pr_segment_feedback_status" placeholder="Enter Status" value="<?php echo $segment_feedback_status; ?>" required>
            </div>

            <div class="buttonSubmit">
                <input type="submit" name="update" value="Update">
            </div>
        </div>
    </form>

</body>
</html>

