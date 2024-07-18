<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";

// Pagination configuration
$results_per_page = 10;

// Establish connection to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine current page for pagination
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// SQL query to select all records from obituaries table with pagination
$sql = "SELECT * FROM obituaries LIMIT $offset, $results_per_page";
$result = $conn->query($sql);

// Fetch data into an associative array
$obituaries = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $obituaries[] = $row;
    }
}

// Count total records for pagination
$count_sql = "SELECT COUNT(*) AS total FROM obituaries";
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_records / $results_per_page);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Obituaries</title>
    <style>
        /* CSS for table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .pagination a:hover:not(.active) {background-color: #ddd;}
    </style>
</head>
<body>
    <h1>Obituaries</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Date of Death</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($obituaries as $obituary): ?>
                <tr>
                    <td><?php echo $obituary['name']; ?></td>
                    <td><?php echo $obituary['date_of_birth']; ?></td>
                    <td><?php echo $obituary['date_of_death']; ?></td>
                    <!-- Render more columns as needed -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="pagination">
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <a href="?page=<?php echo $page; ?>" <?php if ($page == $current_page) echo 'class="active"'; ?>><?php echo $page; ?></a>
        <?php endfor; ?>
    </div>
    <footer>
            <!-- Social media sharing buttons -->
            <div class="social-share">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://example.com/view_obituary.php?id=' . $obituaries[0]['id']); ?>" target="_blank" rel="noopener noreferrer">Share on Facebook</a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://example.com/view_obituary.php?id=' . $obituaries[0]['id']); ?>&text=<?php echo urlencode($obituaries[0]['name'] . ' - Obituary'); ?>" target="_blank" rel="noopener noreferrer">Tweet</a>
                <!-- Add more social media buttons as needed -->
            </div>
        </footer>
</body>
</html>
