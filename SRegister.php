<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $retype_password = htmlspecialchars(trim($_POST['retype_password']));

    // Regex patterns
    $fullNamePattern = "/^[a-zA-Z]+,\\s[a-zA-Z]+\\s[a-zA-Z]\\.$/";
    $phonePattern = "/^09\\d{9}$/";
    $addressPattern = "/^(\\d+\\s)?[A-Za-z\\s]+\\sSt\\.,\\s(\\d+\\s)?[A-Za-z0-9\\s]+,\\s[A-Za-z\\s]+$/";

    // Validate full name
    if (!preg_match($fullNamePattern, $full_name)) {
        echo "<script>alert('Invalid Full Name format: Last, First M.'); window.location.href='Register.html';</script>";
        exit;
    }

    // Validate phone number
    if (!preg_match($phonePattern, $phone)) {
        echo "<script>alert('Invalid phone number. Must start with 09 and be 11 digits.'); window.location.href='Register.html';</script>";
        exit;
    }

    // Validate email
    if (!preg_match("/^[a-zA-Z0-9._%+-]+@(gmail\\.com|addu\\.edu\\.ph)$/", $email)) {
        echo "<script>alert('Invalid email format. Use @gmail.com or @addu.edu.ph only.'); window.location.href='Register.html';</script>";
        exit;
    }

    // Validate address
    if (!preg_match($addressPattern, $address)) {
        echo "<script>alert('Address must follow the format: # Text St., Block or Text, City Name.'); window.location.href='Register.html';</script>";
        exit;
    }

    // Validate passwords match
    if ($password !== $retype_password) {
        echo "<script>alert('Passwords do not match!'); window.location.href='Register.html';</script>";
        exit;
    }

    // Save data to CSV
    $file = __DIR__ . '/users.csv';
    $fileHandle = fopen($file, 'a');
    if ($fileHandle === false) {
        die("<script>alert('Error: Unable to open or create the file.'); window.location.href='Register.html';</script>");
    }

    if (fputcsv($fileHandle, array($full_name, $address, $phone, $email, $password)) === false) {
        die("<script>alert('Error: Unable to write data to the file.'); window.location.href='Register.html';</script>");
    }

    fclose($fileHandle);
    echo "<script>alert('Registration successful!'); window.location.href='Login.html';</script>";
}
?>
