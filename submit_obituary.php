<?php
// Step 3: Establish a connection to the obituary_platform database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";

$conn = new mysqli($servername, $username, $password, $dbname);

// Step 6: Implement error handling for database connection issues
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Capture the form data
$name = $_POST['name'];
$date_of_birth = $_POST['date_of_birth'];
$date_of_death = $_POST['date_of_death'];
$content = $_POST['content'];
$author = $_POST['author'];
$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

// Step 4: Insert the captured data into the obituaries table
$sql = "INSERT INTO obituaries ( name, date_of_birth, date_of_death, content, author, slug)
        VALUES ('$name', '$date_of_birth', '$date_of_death', '$content', '$author', '$slug')";

if ($conn->query($sql) === TRUE) {
    // Step 5: Provide a confirmation message to the user upon successful submission
    echo "New obituary submitted successfully";
} else {
    // Step 6: Implement error handling for data insertion failures
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>