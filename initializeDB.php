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
  $dbname = "`".str_replace("`","``",$dbname)."`";
  $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
  $conn->query("use $dbname");
} catch(PDOException $e) {
  echo "Table creation error. <br>" . $e->getMessage();
}

// $conn = null;

try {
    // $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // // set the PDO error mode to exception
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // sql to create table
    // max amount is 9999.99
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS $tablename (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    userID INT(9) NOT NULL,
    transactionID INT(6) NOT NULL,
    details VARCHAR(100) NOT NULL,
    amount VARCHAR(7) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
  
    // use exec() because no results are returned
    $conn->prepare($sqlCreateTable)->execute();
    echo "Table $tablename created successfully<br/>";
    
    try {
        // sql to insert data into table
        $sqlInsertData = "INSERT INTO $tablename (userID, transactionID, details, amount)
        VALUES (:userID, :transactionID, :details, :amount)";
        
        $stmt = $conn->prepare($sqlInsertData);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':transactionID', $transactionID);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':amount', $amount);

        // insert user 1 transaction 1
        $userID = '123456789';
        $transactionID = '0';
        $details = 'Mcdonald big mac fries';
        $amount = '20';
        $stmt->execute();

        // insert user 1 transaction 2
        $userID = '123456789';
        $transactionID = '21';
        $details = 'Fitness barbells';
        $amount = '150';
        $stmt->execute();

        // insert user 1 transaction 3
        $userID = '123456789';
        $transactionID = '2';
        $details = 'Fitness rowing machine';
        $amount = '239';
        $stmt->execute();

        // insert user 1 transaction 4
        $userID = '123456789';
        $transactionID = '374';
        $details = 'Yoga mat fit plus';
        $amount = '12';
        $stmt->execute();

        // insert user 2 transaction 1
        $userID = '111111111';
        $transactionID = '0';
        $details = 'Starbucks Mocha Cookie Crumble Frappuccino';
        $amount = '9999';
        $stmt->execute();

        // insert user 3 transaction 2
        $userID = '111111111';
        $transactionID = '1';
        $details = "Gino's Large Pepperino Pizza";
        $amount = '13';
        $stmt->execute();

        echo "6 new records across 2 users were created successfully";
      } catch(PDOException $e) {
        echo $sqlInsertData . "<br>" . $e->getMessage();
      }
  } catch(PDOException $e) {
    echo $sqlCreateTable . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>