<?php
session_start();

include('connect/db.php');

if (isset($_REQUEST['submit'])) {
  $name = $_REQUEST['username'];
  $email = $_REQUEST['email'];
  $newUsername = mysqli_real_escape_string($conn, $name); // Make sure to sanitize the input
  $newEmail = mysqli_real_escape_string($conn, $email); // Make sure to sanitize the input

  // Check if the username already exists in the database
  $checkQuery = "SELECT * FROM users WHERE username = '$newUsername' OR email = '$newEmail'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    $row = mysqli_fetch_assoc($checkResult);
    if ($row['username'] === $newUsername && $row['email'] === $newEmail) {
      // Both username and email already exist
      echo "<script>alert('Sorry, the username \'$newUsername\' and the email \'$newEmail\' are already taken. Please choose different ones.');</script>";
    } elseif ($row['username'] === $newUsername) {
      // Username already exists
      echo "<script>alert('Sorry, the username \'$newUsername\' is already taken. Please choose a different username.');</script>";
    } elseif ($row['email'] === $newEmail) {
      // Email already exists
      echo "<script>alert('Sorry, the email \'$newEmail\' is already taken. Please choose a different email.');</script>";
    }
  } else {
    $sql = "INSERT INTO users(name, email, username, password) VALUES ('" . $_REQUEST['name'] . "','" . $_REQUEST['email'] . "', '" . $_REQUEST['username'] . "', '" . $_REQUEST['password'] . "');";


    if ($conn->multi_query($sql) === TRUE) {
      echo "<script>alert('Account Created')</script>";
      $_SESSION['email'] = $_REQUEST['email'];
      // header("Location: http://localhost/Database/pages-login.php");
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dairy Farm</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
  #username-error {
    color: red;
  }

  #password-error {
    color: red;
  }
</style>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center bg-light">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <h1>Dairy Farm</h1>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create Your Account</h5>
                    <p class="text-center small">Enter your credential to create account</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" id="signupForm">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Name</label>
                      <div class="input-group has-validation">
                        <input type="text" name="name" class="form-control" id="yourName" oninput="validateNameInput(event)" required>
                      </div>
                    </div>
                    <div id="nameErrorMessage"></div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" id="username" oninput="validateUsername()" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div id="username-error"></div>
                    <!-- <span id="usernameError" style="color: red;"></span> -->

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="username" oninput="validateUsername()" required>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" oninput="validatePassword()" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div id="password-error"></div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="submit" type="submit">Create Account</button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="pages-login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    // Function to validate the username input
    function validateUsername() {
      const usernameInput = document.getElementById('username');
      const errorDiv = document.getElementById('username-error');
      const username = usernameInput.value;

      // Check for capital letters or special characters
      if (/[A-Z!@#$%^&*(),.?":{}|<>]/.test(username) || /[^a-zA-Z0-9]/.test(username)) {
        errorDiv.textContent = 'Username should not contain capital letters or special characters.';
        usernameInput.setCustomValidity('Invalid characters');
      } else {
        errorDiv.textContent = '';
        usernameInput.setCustomValidity('');
      }
    }



    document.getElementById('signupForm').addEventListener('submit', function(event) {
      const usernameInput = document.getElementById('username');
      const errorDiv = document.getElementById('username-error');
      const username = usernameInput.value;

      // Check for capital letters or special characters
      if (/[A-Z!@#$%^&*(),.?":{}|<>]/.test(username) || /[^a-zA-Z0-9]/.test(username)) {
        errorDiv.textContent = 'Username should not contain capital letters or special characters.';
        usernameInput.focus(); // Focus on the username input field
        event.preventDefault(); // Prevent form submission
      } else {
        errorDiv.textContent = ''; // Clear error message
      }
    });





    // Function to validate the name input
    function validateNameInput(event) {
      var keyCode = event.keyCode || event.which;
      var charStr = String.fromCharCode(keyCode);
      var regex = /^[a-zA-Z]+$/;

      // Check if the entered character is not an alphabet
      if (!regex.test(charStr)) {
        event.preventDefault(); // Prevent the default action (typing the character)

      }
    }

    // Add an event listener to the name input field to trigger validation
    document.getElementById('yourName').addEventListener('keypress', validateNameInput);

    function validatePassword() {
      const passwordInput = document.getElementById('password');
      const errorDiv = document.getElementById('password-error');
      const password = passwordInput.value;

      // Check for minimum length
      if (password.length < 8) {
        errorDiv.textContent = 'Password must be at least 8 characters long.';
        passwordInput.setCustomValidity('Password too short');
        return;
      }

      // Check for presence of at least one alphabet
      if (!/[a-zA-Z]/.test(password)) {
        errorDiv.textContent = 'Password must contain at least one alphabet.';
        passwordInput.setCustomValidity('Missing alphabet');
        return;
      }

      // Check for presence of at least one special character
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        errorDiv.textContent = 'Password must contain at least one special character.';
        passwordInput.setCustomValidity('Missing special character');
        return;
      }

      // Clear error message if password meets all criteria
      errorDiv.textContent = '';
      passwordInput.setCustomValidity('');
    }

    function validatePasswords() {
      const currentPassword = document.getElementById('currentPassword');
      const newPassword = document.getElementById('newPassword');
      const renewPassword = document.getElementById('renewPassword');
      const errorDiv = document.getElementById('password-error');

      const password = renewPassword.value;

      // Check for capital letters
      if (!/[A-Z]/.test(password[0])) {
        errorDiv.textContent = 'First letter of the password should be a capital letter.';
        renewPassword.setCustomValidity('Invalid first letter');
        return;
      }

      // Check for at least 2 special characters
      if ((password.match(/[!@#$%^&*(),.?":{}|<>]/g) || []).length < 2) {
        errorDiv.textContent = 'Password should contain at least 2 special characters.';
        renewPassword.setCustomValidity('Insufficient special characters');
        return;
      }

      // Check for a number
      if (!/\d/.test(password)) {
        errorDiv.textContent = 'Password should contain at least one number.';
        renewPassword.setCustomValidity('No number found');
        return;
      }

      // If all checks pass, reset the error message and validation state
      errorDiv.textContent = '';
      renewPassword.setCustomValidity('');
    }
  </script>
</body>

</html>

