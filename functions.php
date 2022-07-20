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
        $conn->prepare($sqlQueryUserId)->execute();
        $conn = null;
        return True;
    } catch(PDOException $e) {
        // echo $sqlQueryUserId . "<br>" . $e->getMessage();
        $conn = null;
        return False;
    }
}

//get list of user's transactions
function get_user_transaction_list(int $user_id):array {
    global $tablename;

    $conn = connect_DB();
    try {
        // sql to extract the user's previous transaction details
        $sqlGetTransactionList = "SELECT transactionID, details, amount FROM $tablename WHERE userID = $user_id";
        $stmt= $conn->prepare($sqlGetTransactionList);
        $stmt->execute();
        // convert PDO statement into array
        $transaction_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $transaction_list;
    } catch(PDOException $e) {
        // echo $sqlGetTransactionList . "<br>" . $e->getMessage();
        $conn = null;
        return array();
    }
}

//get user's transaction by description
function get_transaction_by_desc(int $user_id, string $desc):array {
    global $tablename;

    $conn = connect_DB();
    try {
        $sqlGetTransactionByDetails = "SELECT transactionID, details, amount FROM $tablename WHERE userID = $user_id AND details LIKE '%$desc%'";
        $stmt= $conn->prepare($sqlGetTransactionByDetails);
        $stmt->execute();
        // convert PDO statement into array
        $transaction_list= $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $transaction_list;
    } catch(PDOException $e) {
        // echo $sqlGetTransactionByDetails . "<br>" . $e->getMessage();
        $conn = null;
        return array();
    }
}

//update transaction amount
function update_amount(int $user_id, int $transaction_id, int $amount):bool {
    global $tablename;

    $conn = connect_DB();
    try {
        $sqlUpdateAmount = "UPDATE $tablename SET amount = $amount WHERE userID = $user_id AND transactionID = $transaction_id";
        $conn->prepare($sqlUpdateAmount)->execute();
        $conn = null;
        return True;
    } catch(PDOException $e) {
        // echo $sqlUpdateAmount . "<br>" . $e->getMessage();
        $conn = null;
        return False;
    }
}

//update transaction description
function update_desc(int $user_id, int $transaction_id, string $desc):bool {
    global $tablename;

    $conn = connect_DB();
    try {
        $sqlUpdateDetails = "UPDATE $tablename SET details = '$desc' WHERE userID = $user_id AND transactionID = $transaction_id";
        $conn->prepare($sqlUpdateDetails)->execute();
        $conn = null;
        return True;
    } catch(PDOException $e) {
        // echo $sqlUpdateDetails . "<br>" . $e->getMessage();
        $conn = null;
        return False;
    }
}


// UPDATE CreditHistory SET amount = 10.00 WHERE userID = 123456789 AND transactionID = 0
// UPDATE CreditHistory SET details = "Two Fitness barbells" WHERE userID = 123456789 AND transactionID = 21
?>