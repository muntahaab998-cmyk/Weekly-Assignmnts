
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Array Results</title>
</head>
<body>
<h2>WeeklyParticipationEight - Results</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST"
    || !isset($_POST["values"])
    || !is_array($_POST["values"])
    || count($_POST["values"]) !== 8) {
    exit("Please enter eight values using the form.");
}

// Store the eight submitted values in an array
$values = array_values(array_map(
    "strval", $_POST["values"]
));

// Function to display an array with and without keys
function displayArray($title, $array) {
    echo "<h3>" . htmlspecialchars($title) . "</h3>";

    echo "<b>Without keys:</b><br>";
    foreach ($array as $value) {
        echo htmlspecialchars($value) . "<br>";
    }

    echo "<br><b>With keys:</b><br><pre>";
    print_r($array);
    echo "</pre><hr>";
}

// 1. Original array
displayArray("Original Array", $values);

// 2. Delete two elements
unset($values[1], $values[3]);
displayArray("Array After Deleting Two Elements", $values);

// 3. Remove gaps and reset indexes
$values = array_values($values);
displayArray("Array After Removing Gaps", $values);

// 4. Sort in ascending order
sort($values);
displayArray("Array Sorted in Ascending Order", $values);

// 5. Sort in descending order
rsort($values);
displayArray("Array Sorted in Descending Order", $values);

// 6. Sort by value while keeping keys
asort($values);
displayArray("Ascending Order While Keeping Keys", $values);

// 7. Sort according to keys
ksort($values);
displayArray("Ascending Order According to Keys", $values);
?>

</body>
</html>
