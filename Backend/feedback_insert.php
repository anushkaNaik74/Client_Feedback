<?php

    require '../Database/database.php';

    if (!$con) {
        die('error in db' . mysqli_error($con));
    }

    // Variables to store form data
    $segment_feedback_client = $segment_feedback_desc = $segment_feedback_status = '';


    if(isset($_POST['submit'])){

        $segment_feedback_client             = $_POST['pr_segment_feedback_client'];
        $segment_feedback_desc              = $_POST['pr_segment_feedback_desc'];
        $segment_feedback_status             = $_POST['pr_segment_feedback_status'];


        // I the same client want to insert feedback
        $duplicate_query = "SELECT * from pr_segment_feedback WHERE (pr_segment_feedback_client = '$segment_feedback_client')";

        $duplicate_query_sql = mysqli_query($con, $duplicate_query);  
        $count_duplicate_query_rows = mysqli_num_rows($duplicate_query_sql);
        if($count_duplicate_query_rows > 0){
            $update_query = "UPDATE pr_segment_feedback SET 
                                    pr_segment_feedback_desc = '{$segment_feedback_desc}',
                                    pr_segment_feedback_status = '{$segment_feedback_status}'                              
                            WHERE pr_segment_feedback_client = '$segment_feedback_client' "; 
        
            $update_query_sql = mysqli_query($con, $update_query);  
            if($update_query_sql){
                header("Location: feedback_insert.php");
        
            }
        }
        else{
            // Insert data into the database
                $insert_feedback_query = "INSERT INTO pr_segment_feedback (
                    pr_segment_feedback_client, 
                    pr_segment_feedback_desc, 
                    pr_segment_feedback_status
                        
                ) VALUES (
                    '$segment_feedback_client', 
                    '$segment_feedback_desc', 
                    '$segment_feedback_status'
                )";

            // Execute the SQL query

            if (mysqli_query($con, $insert_feedback_query)) {
                // Redirect to another page after successful insertion
                header('Location: feedback_insert.php');
                exit; // Make sure to exit after redirection
            } else {
                echo "Error: " . $insert_feedback_query . "<br>" . mysqli_error($con);
            }
        }

        
    } 
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Feedback</title>
    <link rel="stylesheet" href="../Styles/styles.css">
</head>
<body>
    <form id="feedback_form" method="post">
        <div class="wrapper">
            <div class="form-row">
                <label for="pr_segment_feedback_client">Client</label>
                <!-- <input type="number" name="pr_segment_feedback_client" id="pr_segment_feedback_client" placeholder="Enter Client" required> -->
                <select onChange="" name="pr_segment_feedback_client" tabindex="1" required>
                            <option value="">Select Client</option>
                            <?php 
                                        $query =mysqli_query($con,"SELECT * FROM pr_clients");
                                    while($row=mysqli_fetch_assoc($query))
                                    { 
                                        $pr_client_code = $row['pr_client_code'];
                                        $pr_segment_feedback_client = ucfirst($row['pr_client_name']);  
                                        ?>
                                    <option class="divShow"  value="<?php echo $pr_client_code; ?>" ><?php echo $pr_segment_feedback_client; ?></option>
                                    <?php
                                    }
                                
                            ?>
                        </select>
            </div>

            <div class="form-row">
                <label for="pr_segment_feedback_desc">Feedback</label>
                <textarea name="pr_segment_feedback_desc" id="pr_segment_feedback_desc" placeholder="Enter Feedback" required></textarea>
            </div>

            <div class="form-row">
                <label for="pr_segment_feedback_status">Status</label>
                <input type="number" name="pr_segment_feedback_status" id="pr_segment_feedback_status" placeholder="Enter Status" required>
            </div>

            <div class="buttonSubmit">
                <input type="submit" name="submit" value="Submit">
            </div>
        </div>
    </form>

    <h3>Client Feedbacks</h3>
    <table>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Feedback</th>
            <th>Status</th> 
            <th>Operations</th> 
        </tr>

        <?php
        $i = 1;
        $select_all_feedback_query = "SELECT * FROM pr_segment_feedback";
        $select_all_feedback_query_sql = mysqli_query($con, $select_all_feedback_query);
        $count_select_all_feedback_query = mysqli_num_rows($select_all_feedback_query_sql);

        if($count_select_all_feedback_query  > 0){
            while ($row = $select_all_feedback_query_sql -> fetch_assoc()) {
            $id = $row['pr_segment_feedback_id'];
        ?>

        <tr>
        <td><?php echo $i++ ?></td>
        <td><?php echo $row['pr_segment_feedback_client']?></td>
        <td><?php echo $row['pr_segment_feedback_desc']?></td>
        <td><?php echo $row['pr_segment_feedback_status']?></td>

        <td class="operations">
            <a href="feedback_update.php?id=<?php echo $id; ?>" class="edit-button">Edit</a>
            <a href="feedback_delete.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure?')" class="delete-button">Delete</a>
        </td>
        </tr>

        <?php 
            }
        }
        ?>
    </table>
</body>
</html>
