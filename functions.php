<?php
declare(strict_types=1);

$servername = "localhost";
$username = "root";
$password = "CP476project"; // may need to be change to match your mysql database password
$dbname = "CardDatabase";
$tablename = "CreditHistory";

function connect_DB() {
    global $servername, $dbname, $username, $password;

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}

// returns true if the user id exists in the database, otherwise false
function check_user_exists(int $user_id):bool {
    global $tablename;

    $conn = connect_DB();
    try {
        // sql to check if user id in database
        $sqlQueryUserId = "SELECT userID FROM $tablename WHERE userID = $user_id";
        $conn->query($sqlQueryUserId);
        $conn = null;
        return True;
    } catch(PDOException $e) {
        $conn = null;
        return False;
    }
}

//get list of user's transactions
function get_user_transaction_list(int $user_id, string $desc):array {
    global $tablename;

    $conn = connect_DB();
    try {
        // sql to extract the user's previous transaction details
        $sqlGetTransactionList = "SELECT transactionID, details, amount FROM $tablename WHERE userID = $user_id";
        $stmt = $conn->query($sqlGetTransactionList);
        $transaction_list= $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $transaction_list;
    } catch(PDOException $e) {
        echo $sqlGetTransactionList . "<br>" . $e->getMessage();
        $conn = null;
        return array();
    }
}

//get user's transaction by description
function get_transaction_by_desc(int $user_id, string $desc):array {
    global $tablename;

    $conn = connect_DB();
    try {
        // sql to extract the user's previous transaction details
        $sqlGetTransactionByDetails = "SELECT transactionID, details, amount FROM $tablename WHERE userID = $user_id AND details LIKE $desc";
        $transaction_list = $conn->query($sqlGetTransactionByDetails);
        $conn = null;
        print_r($transaction_list);
        return transaction_list;
    } catch(PDOException $e) {
        echo $sqlGetTransactionByDetails . "<br>" . $e->getMessage();
        $conn = null;
        return array();
    }
}



// try {
//   $conn = new PDO("mysql:host=$servername", $username, $password);
//   // set the PDO error mode to exception
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   $sqlCreateDB = "CREATE DATABASE $dbname";
//   // use exec() because no results are returned
//   $conn->exec($sqlCreateDB);
//   echo "Database created successfully<br>";
// } catch(PDOException $e) {
//   echo $sqlCreateDB . "<br>" . $e->getMessage();
// }

// $conn = null;

// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
//     // sql to create table
//     // max amount is 9999.99
//     $sqlCreateTable = "CREATE TABLE $tablename (
//     id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
//     userID INT(9) NOT NULL,
//     transactionID INT(6) NOT NULL,
//     details VARCHAR(100) NOT NULL,
//     amount VARCHAR(7) NOT NULL,
//     reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//     )";
  
//     // use exec() because no results are returned
//     $conn->exec($sqlCreateTable);
//     echo "Table $tablename created successfully";
    
//     try {
//         // sql to insert data into table
//         $sqlInsertData = "INSERT INTO $tablename (userID, transactionID, details, amount)
//         VALUES ('123456789', '0', 'Mcdonald big mac fries', '20.00')";
//         // use exec() because no results are returned
//         $conn->exec($sqlInsertData);
//         echo "New record created successfully";
//       } catch(PDOException $e) {
//         echo $sqlInsertData . "<br>" . $e->getMessage();
//       }
//   } catch(PDOException $e) {
//     echo $sqlCreateTable . "<br>" . $e->getMessage();
//   }
  
//   $conn = null;

?>