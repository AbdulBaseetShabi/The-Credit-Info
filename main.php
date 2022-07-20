<?php
define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/functions.php');
session_start();

//LOG USER OUT
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['logout']) && $_POST['logout'] === "logout") {
    session_destroy();
    header("Location: /login.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
        }

        #body {
            width: 100%;
            height: 100%;
            background-color: #6187cb;
            position: relative;
        }

        #footer {
            text-align: center;
            border: 5px solid black;
            display: block;
            position: absolute;
            bottom: 0px;
            background-color: lavender;
            padding: 10px;
            box-sizing: border-box;
            width: 100%;
            font-family: cursive;
        }

        #title {
            font-size: 2rem;
            font-weight: bolder;
            font-family: fantasy;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        #search-query {
            width: 70%;
            padding: 7px;
            text-align: center;
            border: 2px solid;
            border-radius: 7px;
            box-sizing: border-box;
            font-size: 15px;
            font-weight: 900;
            font-family: cursive;
        }

        #header {
            height: 125px;
            width: 100%;
            background-color: lavender;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border-bottom: 5px solid black;
            border-top: 5px solid black;
            box-sizing: border-box;
            padding: 10px;
        }

        #search {
            width: 80%;
            float: left;
            display: flex;
            justify-content: center;
        }

        #search-button {
            background-color: #2cb67d;
            width: 20%;
            height: 30px;
            margin-top: 5px;
            margin-left: 7px;
            text-align: center;
            border-radius: 1.5rem;
            box-sizing: border-box;
            cursor: pointer;
            user-select: none;
            font-family: cursive;
            font-weight: 600;
            text-transform: uppercase;
            border: none;
            box-shadow: 5px 5px black;
        }

        #results {
            overflow-y: auto;
            margin: 5px;
            max-height: calc(100vh - 190px);
            box-sizing: border-box;
            /* scrollbar-width: thin; */
        }

        #results::-webkit-scrollbar-thumb {
            background: lavender;
            border-radius: 20px;
            margin: 2px;
        }

        #results::-webkit-scrollbar {
            border-radius: 20px;
            border: 3px solid black;
            width: 15px;
        }

        .card {
            width: 95%;
            padding: 10px;
            border-left: 5px solid #2cb67d;
            box-sizing: border-box;
            margin: 0.8rem auto;
            padding: 0.7rem;
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.2);
            background-color: black;
            color: #fffffe;
            font-family: cursive;
            display: flex;
        }

        .row {
            display: block;
            font-weight: 100;
        }

        .row span {
            font-weight: 900;
        }

        .row input {
            font-size: 15px;
            font-weight: 600;
            font-style: italic;
            font-family: cursive;
            margin-top: 4px;
        }

        #card-buttons {
            width: 20%;
            border-left: 2px solid white;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;

        }

        #card-inputs {
            width: 80%;
        }

        #card-buttons button {
            width: 80%;
            margin: 0 auto;
            font-family: cursive;
            font-weight: 900;
            border-radius: 20px;
            padding: 5px;
            cursor: pointer;
            user-select: none;
        }

        #query-form {
            width: 100%;
        }

        #alert {
            width: 30%;
            position: absolute;
            bottom: 50px;
            right: 20px;
            border-left: 5px solid orange;
            min-height: 50px;
        }

        #logout-button {
            position: absolute;
            bottom: 60px;
            left: 25%;
            background-color: #c93f3f;
            width: 40%;
            height: 30px;
            text-align: center;
            border-radius: 1.5rem;
            box-sizing: border-box;
            cursor: pointer;
            user-select: none;
            font-family: cursive;
            font-weight: 600;
            text-transform: uppercase;
            border: none;
            box-shadow: 5px 5px black;
        }
    </style>
</head>

<body>
    <div id="body">
        <div id="header">
            <label id="title">CREDERE</label>
            <div id="search">
                <form id="query-form" method="post" action="/main.php">
                    <input id="search-query" type="text" name="query" placeholder="Enter a description" autocomplete="off" />
                    <button id="search-button" type="submit" form="query-form">Search</button>
                </form>
            </div>
        </div>
        <div id="results">
            <?php
            //CHECK IF USER IS LOGGED IN
            if (isset($_SESSION["uid"]) && !empty($_SESSION["uid"])) {
                $uid = $_SESSION["uid"];
                $query = "";


                //MAKE UPDATES TO DATABASE
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['transaction_id'])) {
                    $tid = $_POST['transaction_id']; //SANTIZE?
                    if (isset($_POST['amount'])) {
                        $amount = $_POST['amount'];
                        $successful_update = update_amount($uid, $tid, $amount);

                        //UPDATE THE DATA using uid and tid
                        if ($successful_update) {
                            echo "<div class='card' id='alert'> Amount was successfully updated for transaction_id: $tid </div>";
                        } else {
                            echo "<div class='card' id='alert'> Update unsuccessful. Error Occured: This is the error </div>";
                        }
                    } else if (isset($_POST['description'])) {
                        $description = filter_var(htmlspecialchars($_POST['description']), FILTER_UNSAFE_RAW);
                        $successful_update = update_desc($uid, $tid, $description);

                        //UPDATE THE DATA using uid and tid
                        if ($successful_update) {
                            echo "<div class='card' id='alert'> Description was successfully updated for transaction_id: $tid </div>";
                        } else {
                            echo "<div class='card' id='alert'> Update unsuccessful. Error Occured: This is the error </div>";
                        }
                    } else {
                        echo "<div class='card' id='alert'> Invalid Post REQUEST</div>";
                    }
                }

                //DISPLAY RESULTS IN DB
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["query"])) {
                    $query = filter_var(htmlspecialchars($_POST["query"]), FILTER_UNSAFE_RAW);
                }

                // GET RESULTS
                $results = array();

                if (strlen($query) > 0) {
                    $transaction_list = get_transaction_by_desc($uid, $query);
                } else {
                    $transaction_list = get_user_transaction_list($uid);
                }

                foreach ($transaction_list as $item) {
                    array_push($results, array('transaction_id' => $item['transactionID'], 'description' => $item['details'], 'amount' => $item['amount']));
                }

                if (count($results) > 0) {
                    foreach ($results as $result) {
                        echo "<div class='card'>";
                        echo "<div id='card-inputs'>";
                        echo "<label class='row'><span>Transaction ID: </span>" . $result["transaction_id"] . "</label>";
                        echo "<form id='amount-form-" . $result["transaction_id"] . "' method='post' action='/main.php'><label class='row'><span>Amount: </span>$<input type='number' name='amount' value=" . $result['amount'] . " style='width: 10%' /></label> <input type='hidden' name='transaction_id' value=" . $result['transaction_id'] . " /></form>";
                        echo "<form id='description-form-" . $result["transaction_id"] . "' method='post' action='/main.php'><label class='row'><span>Description: </span><input type='text' name='description' value='" . $result['description'] . "' style='width: 85%'/></label><input type='hidden' name='transaction_id' value=" . $result['transaction_id'] . " /></form>";
                        echo "</div>";
                        echo "<div id='card-buttons'>";
                        echo "<button type='submit' form='amount-form-" . $result["transaction_id"] . "' style='background-color: #2cb67d;'>Update Amount</button>";
                        echo "<button type='submit' form='description-form-" . $result["transaction_id"] . "' style='background-color: #329fc4;'>Update Description</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }else{
                    echo "<div class='card' id='alert'> Either the database is empty or the search key provided has no corresponding data in the database</div>";
                }

            } else {
                header("Location: /login.php");
            }
            ?>

        </div>
        <form id="logout-form" method="post" action="/main.php">
            <input type="hidden" name="logout" value="logout" />
            <button id="logout-button" type="submit" form="logout-form">Logout</button>
        </form>
        <label id="footer">Created by <span style="font-weight: 700;">The Humans Trying to Pass (HTTP)</span></label>
    </div>
</body>

</html>
