<?php
$servername = "localhost";
$username = "root";
$password = "CP476project"; // may need to be change to match your mysql database password
$dbname = "CardDatabase";
$tablename = "CreditHistory";

try {
  $conn = new PDO("mysql:host=$servername", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sqlCreateDB = "CREATE DATABASE $dbname";
  // use exec() because no results are returned
  $conn->exec($sqlCreateDB);
  echo "Database created successfully<br>";
} catch(PDOException $e) {
  echo $sqlCreateDB . "<br>" . $e->getMessage();
}

$conn = null;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // sql to create table
    // max amount is 9999.99
    $sqlCreateTable = "CREATE TABLE $tablename (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    userID INT(9) NOT NULL,
    transactionID INT(6) NOT NULL,
    details VARCHAR(100) NOT NULL,
    amount VARCHAR(7) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
  
    // use exec() because no results are returned
    $conn->exec($sqlCreateTable);
    echo "Table $tablename created successfully";
    
    try {
        // sql to insert data into table
        $sqlInsertData = "INSERT INTO $tablename (userID, transactionID, details, amount)
        VALUES ('123456789', '0', 'Mcdonald big mac fries', '20.00')";
        // use exec() because no results are returned
        $conn->exec($sqlInsertData);
        echo "New record created successfully";
      } catch(PDOException $e) {
        echo $sqlInsertData . "<br>" . $e->getMessage();
      }
  } catch(PDOException $e) {
    echo $sqlCreateTable . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>