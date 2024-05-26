<?php
include('connect/db.php');
include('header.php');
include('nav.php');
include('slider.php');

$sql = "SELECT * FROM record";
$result = mysqli_query($conn, $sql);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 card bg-light">
            <h1 class="text-center mb-5 pt-3">GYM Records</h1>
            <table id="gymTable" class="display">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client ID</th>
                        <th>Client Name</th>
                        <th>Membership Fee</th>
                        <th>CNIC No</th>
                        <th>Membership Expiry</th>
                      
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["client_id"] . "</td>";
                            echo "<td>" . $row["client_name"] . "</td>";
                            echo "<td>" . $row["membership_fee"] . "</td>";
                            echo "<td>" . $row["cnic_no"] . "</td>";
                            echo "<td>" . $row["membership_expiry"] . "</td>";
                            
                            echo "<td>";
                            echo '<a href="edit.php?id=' . $row['id'] . '" type="button" class="btn btn-primary">Edit</a> ';
                            echo '<a href="delete.php?id=' . $row['id'] . '" type="button" class="btn btn-danger">Delete</a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No Records Found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
