

 

<?php
//Makes DB connection
$servername = "sql1.njit.edu";
$username = "mmc72";
$password = "pBz~mDo-0?-^8OCOr9wo";
$dbname = "mmc72";
$con = mysqli_connect($servername,$username,$password,$dbname);
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
 {
echo "CONNECTED ";
}
?>
