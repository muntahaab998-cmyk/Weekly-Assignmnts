
<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = trim($_POST["studentID"] ?? "");

    $sql = "SELECT ID FROM Student WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $studentID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        session_regenerate_id(true);
        $_SESSION["studentID"] = $studentID;
        header("Location: student.php");
        exit();
    } else {
        $error = "STUDENT ID NOT FOUND. Please re-enter.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Week 10 - Student Search</title>
</head>
<body>

<form method="POST" action="">
    <label><b>Student ID</b></label>
    <input type="text" name="studentID" required>
    <br>
    <input type="submit" value="Submit">
</form>

<?php if (!empty($error)): ?>
<script>
    alert(<?php echo json_encode($error); ?>);
</script>
<?php endif; ?>

</body>
</html>
