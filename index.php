<?php
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1> PDO Demo </h1>";

require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';

try{
    //Instantiate our PDO databse object
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    echo 'Connected to database';
}
//if doesnt work, catch exception
catch (PDOException $e){
    die( $e->getMessage() );
}

//Print out student list
//Red all query
$sql = "SELECT * FROM student ORDER BY last ASC";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Binding the parameters
//no binding necessary because we are selecting all

//4. Execute the query
$statement->execute();

//5. Process the result
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<h1>Student List</h1>"; //for readability purpose
echo "<ol>";
foreach ($result as $row) {
    echo "<li>".$row['last'] . ", " . $row['first']."</li>"; //the elements can be instantiated for readability
}
echo "</ol>";

//Adding new row with data from newStudent.html
// 1. Define the query, using : as placeholder to input data later
$sql = 'INSERT INTO student (sid, last, first, birthdate, gpa, advisor) VALUES (:sid, :last, :first, :birthdate, :gpa, :advisor)';

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Binding the parameters
$sid = $_POST['sid'];
$last = $_POST['last'];
$first = $_POST['first'];
$birthdate = $_POST['birthdate'];
$gpa = $_POST['gpa'];
$advisor = $_POST['advisor'];

$statement->bindParam(':sid', $sid);
$statement->bindParam(':last', $last);
$statement->bindParam(':first', $first);
$statement->bindParam(':birthdate', $birthdate);
$statement->bindParam(':gpa', $gpa);
$statement->bindParam(':advisor', $advisor);

//4. Execute the query
$statement->execute();

//5. Process the results
$id = $dbh->lastInsertId();
echo "<p>New student was inserted successfully";

//Print out student list
//Red all query
$sql = "SELECT * FROM student ORDER BY last ASC";

//2. Prepare the statement
$statement = $dbh->prepare($sql);

//3. Binding the parameters
//no binding necessary because we are selecting all

//4. Execute the query
$statement->execute();

//5. Process the result
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
echo "<h1>Updated Student List</h1>"; //for readability purpose
echo "<ol>";
foreach ($result as $row) {
    echo "<li>".$row['last'] . ", " . $row['first']."</li>"; //the elements can be instantiated for readability
}
echo "</ol>";