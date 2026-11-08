
<?php
session_start();

if (!isset($_SESSION["studentID"])) {
    header("Location: index.php");
    exit();
}

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
    die("Database connection failed.");
}

$studentID = $_SESSION["studentID"];

$sql = "SELECT Student.Name, Student.ID,
               Student.Major, Transcript.Course,
               Transcript.Grade
        FROM Student
        INNER JOIN Transcript
        ON Student.ID = Transcript.ID
        WHERE Student.ID = ?";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
</head>
<body>

<h2>Student Information</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Student Name</th>
        <th>Student ID</th>
        <th>Major</th>
        <th>Course</th>
        <th>Grade</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Name"]); ?></td>
        <td><?php echo htmlspecialchars($row["ID"]); ?></td>
        <td><?php echo htmlspecialchars($row["Major"]); ?></td>
        <td><?php echo htmlspecialchars($row["Course"]); ?></td>
        <td><?php echo htmlspecialchars($row["Grade"]); ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<br>

<form action="index.php" method="GET">
    <button type="submit">HOME</button>
</form>

</body>
</html>

<?php
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
