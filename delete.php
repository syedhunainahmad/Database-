<?php
include('connect/db.php');
// Check if the 'id' parameter is set in the URL
if(isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];
    
    

    // Construct the SQL DELETE statement
    $sql = "DELETE FROM record WHERE id = $id";

    // Execute the delete query
    if (mysqli_query($conn, $sql)) {
        // Redirect the user to a success page or back to the list page
        echo '<script>alert("Record deleted successfully");</script>';
        header("Location: show.php");
        exit();
    } else {
        // Display an error message if delete operation fails
        echo "Error deleting record: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect the user or show an error message if 'id' parameter is not provided in the URL
    // Example:
    // header("Location: error.php");
    // exit();
}
?>
