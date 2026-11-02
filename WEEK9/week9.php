<!DOCTYPE html>
<html>
<head>
    <title>Week 9 SQL JOIN Assignment</title>
</head>
<body>
<h2>Week 9 - Student Database</h2>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to NJIT MySQL database
$servername = "sql1.njit.edu";
$username = "mmc72";
$password = "pBz~mDo-0?-^8OCOr9wo";
$dbname = "mmc72";

$con = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully!";

// Create Student table
$sql1 = "CREATE TABLE IF NOT EXISTS Student (
    ID INT PRIMARY KEY,
    Name VARCHAR(100),
    Major VARCHAR(100)
)";

if (mysqli_query($con, $sql1)) {
    echo "<p>Student table created successfully!</p>";
} else {
    echo "Error: " . mysqli_error($con);
}

// Create Transcript table
$sql2 = "CREATE TABLE IF NOT EXISTS Transcript (
    ID INT,
    Course VARCHAR(20),
    Grade VARCHAR(5)
)";

if (mysqli_query($con, $sql2)) {
    echo "<p>Transcript table created successfully!</p>";
} else {
    echo "Error: " . mysqli_error($con);
}


 // Insert Student records
$students = "INSERT IGNORE INTO Student (ID, Name, Major)
VALUES
(1234, 'Chloe', 'Computer Science'),
(3456, 'Maeve', 'Biology'),
(5678, 'Raphael', 'Electrical Engineering'),
(9012, 'Francisco', 'Architecture')";

if (mysqli_query($con, $students)) {
    echo "<p>Student records inserted successfully!</p>";
} else {
    echo "<p>Student error: " . mysqli_error($con) . "</p>";
}

// Insert Transcript records
$transcripts = "INSERT INTO Transcript (ID, Course, Grade)
SELECT 1234, 'IT202', 'A'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 1234 AND Course = 'IT202'
)
UNION ALL
SELECT 1234, 'IT201', 'B+'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 1234 AND Course = 'IT201'
)
UNION ALL
SELECT 3456, 'BIOL200', 'A'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 3456 AND Course = 'BIOL200'
)
UNION ALL
SELECT 3456, 'BIOL201', 'A'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 3456 AND Course = 'BIOL201'
)
UNION ALL
SELECT 5678, 'ECE230', 'A'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 5678 AND Course = 'ECE230'
)
UNION ALL
SELECT 5678, 'ECE231', 'B+'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 5678 AND Course = 'ECE231'
)
UNION ALL
SELECT 9012, 'ARCH110', 'A'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 9012 AND Course = 'ARCH110'
)
UNION ALL
SELECT 9012, 'ARCH195', 'B'
WHERE NOT EXISTS (
    SELECT 1 FROM Transcript
    WHERE ID = 9012 AND Course = 'ARCH195'
)";

if (mysqli_query($con, $transcripts)) {
    echo "<p>Transcript records inserted successfully!</p>";
} else {
    echo "<p>Transcript error: " . mysqli_error($con) . "</p>";
}


echo "<h3>Student and Transcript Records</h3>";

$sqlJoin = "SELECT Student.Name, Student.ID,
                   Student.Major, Transcript.Course,
                   Transcript.Grade
            FROM Student
            INNER JOIN Transcript
            ON Student.ID = Transcript.ID
            ORDER BY Student.ID, Transcript.Course";

$result = mysqli_query($con, $sqlJoin);

if ($result) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Name</th><th>ID</th><th>Major</th><th>Course</th><th>Grade</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Major']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Course']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Grade']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "JOIN error: " . mysqli_error($con);
}

echo "<h3>STUDENT TABLE</h3>";

$result = mysqli_query($con, "SELECT Name, ID, Major FROM Student");

if ($result) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Name</th><th>ID</th><th>Major</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Major']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Student table error: " . mysqli_error($con);
}

echo "<h3>TRANSCRIPT TABLE</h3>";

$result = mysqli_query($con, "SELECT ID, Course, Grade FROM Transcript");

if ($result) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Course</th><th>Grade</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Course']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Grade']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Transcript table error: " . mysqli_error($con);
}

?>

</body>
</html>