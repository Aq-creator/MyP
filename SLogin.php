<?php
// Get the username (email) and password from the form
$username = $_POST['username'];  // Assuming 'username' is the email
$password = $_POST['password'];  // Plain-text password entered by the user

// Open the users.csv file to check credentials
$file = 'users.csv';
$fileHandle = fopen($file, 'r');
$foundUser = false;

if ($fileHandle !== false) {
    // Loop through each line (user) in the CSV file
    while (($userData = fgetcsv($fileHandle)) !== false) {
        // Compare the username (email) from the form with the stored email in the CSV
        if ($userData[3] == $username) {  // Assuming the email is in the 4th column (index 3)
            $storedPassword = $userData[4];  // Assuming the plain-text password is in the 5th column (index 4)

            // Directly compare the entered password with the stored plain-text password
            if ($password === $storedPassword) {
                // Password is correct
                $foundUser = true;
                fclose($fileHandle);

                // Redirect to User.html after successful login
                header("Location: index.html");
                exit;  // Make sure to stop further execution
            } else {
                // Invalid password
                fclose($fileHandle);
                // Redirect back to Register.html with an error message
                echo "<script>alert('Invalid password!'); window.location.href = 'Register.html';</script>";
                exit;
            }
        }
    }

    if (!$foundUser) {
        // Username (email) not found, prompt user to register
        echo "<script>alert('This account does not exist. Please register.'); window.location.href = 'Register.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('Error opening file.'); window.location.href = 'Register.html';</script>";
}
?>
