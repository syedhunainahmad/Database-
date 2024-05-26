<?php
include('connect/db.php');
include('header.php');
include('nav.php');
include('slider.php');

if (isset($_GET['id'])) {
    // Retrieve the 'id' value from the URL
    $id = $_GET['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $record_id = $id; // Get the record ID
    $date = $_POST['date'];
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    $membership_fee = $_POST['membership_fee'];
    $cnic_no = $_POST['cnic_no'];

    // Calculate membership expiry date
    $membership_expiry = date('Y-m-d', strtotime($date . ' + 30 days'));

    // Update the database
    $stmt = $conn->prepare("UPDATE record SET date=?, client_id=?, client_name=?, membership_fee=?, cnic_no=?, membership_expiry=? WHERE id=?");
    $stmt->bind_param("sssissi", $date, $client_id, $client_name, $membership_fee, $cnic_no, $membership_expiry, $record_id);

    if ($stmt->execute() === TRUE) {
        echo '<script>alert("Record updated successfully");</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$sql = "SELECT * FROM record WHERE id=$id";
$result = mysqli_query($conn, $sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6 border border-2 bg-light">
                                <h1 class="text-center pt-5 pb-3">Edit Record</h1>
                                <form id="gymForm" method="post" action="">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="<?php echo $row['date']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="clientId" class="form-label">Client ID</label>
                                        <input type="text" class="form-control" id="clientId" name="client_id" value="<?php echo $row['client_id']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="clientName" class="form-label">Client Name</label>
                                        <input type="text" class="form-control" id="clientName" name="client_name" value="<?php echo $row['client_name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="membershipFee" class="form-label">Membership Fee</label>
                                        <input type="number" class="form-control" id="membershipFee" name="membership_fee" value="<?php echo $row['membership_fee']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cnicNo" class="form-label">CNIC No</label>
                                        <input type="text" class="form-control" id="cnicNo" name="cnic_no" value="<?php echo $row['cnic_no']; ?>" required>
                                    </div>

                                    <div class="container pb-3 text-center">
                                        <button type="submit" class="btn btn-primary">Save Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
<?php
    }
} else {
    echo '<script>alert("No record found");</script>';
}

include('footer.php');
?>