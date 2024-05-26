<?php

include('header.php');
include('connect/db.php');

include('nav.php');
include('slider.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $date = $_POST['date'];
    $client_id = $_POST['client_id'];
    $client_name = $_POST['client_name'];
    $membership_fee = $_POST['membership_fee'];
    $cnic_no = $_POST['cnic_no'];
    // $additional_note = $_POST['additional_note'];

    // Calculate membership expiry date
    $membership_expiry = date('Y-m-d', strtotime($date . ' + 30 days'));

    // Perform any additional validation as needed

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO record (date, client_id, client_name, membership_fee, cnic_no, membership_expiry) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $date, $client_id, $client_name, $membership_fee, $cnic_no, $membership_expiry);
    
    // Execute statement
    if ($stmt->execute() === TRUE) {
        echo '<script>alert("New record inserted successfully ");</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 border border-2  bg-light">
                        <h1 class="text-center pt-5 pb-3">GYM Record</h1>
                        <form id="gymForm" method="POST" action="">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="clientId" class="form-label">Client ID</label>
                                <input type="text" class="form-control" id="clientId" name="client_id" placeholder="Enter Client ID" required>
                            </div>
                            <div class="mb-3">
                                <label for="clientName" class="form-label">Client Name</label>
                                <input type="text" class="form-control" id="clientName" name="client_name" placeholder="Enter Client Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="membershipFee" class="form-label">Membership Fee</label>
                                <input type="number" class="form-control" id="membershipFee" name="membership_fee" placeholder="Enter the membership fee" required>
                            </div>
                            <div class="mb-3">
                                <label for="cnicNo" class="form-label">CNIC No</label>
                                <input type="text" class="form-control" id="cnicNo" name="cnic_no" placeholder="Enter CNIC No" required>
                            </div>
                            <!-- <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="additional_note" rows="3" placeholder="Enter any additional notes"></textarea>
                            </div> -->
                            <div class="container pb-3 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
include('footer.php');
?>