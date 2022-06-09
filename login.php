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
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        #login-container {
            height: 200px;
            width: 500px;
            background-color: lavender;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 19px 20px 0px 2px black;
            border: 2px solid black;
            margin-top: -50px;
        }

        .prompt {
            text-align: center;
            width: 100%;
            color: #B33A3A;
        }

        #user-id {
            width: 100%;
            text-align: center;
            padding: 7px;
            border: 2px solid;
            border-radius: 7px;
            box-sizing: border-box;
            font-size: 15px;
            font-weight: 900;
            font-family: cursive;
        }

        #id-input {
            width: 60%;
        }

        #title {
            font-size: 2rem;
            font-weight: bolder;
            font-family: fantasy;
            text-transform: uppercase;
            margin-bottom: 10px;
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

        #login-button {
            background-color: #2cb67d;
            width: 50%;
            height: 30px;
            margin-top: 5px;
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
        <form id="login-container" action="get" action="/main.php">
            <label id="title">The Credit Info</label>
            <div id="id-input">
                <!-- <label>User ID: </label> -->
                <input id="user-id" type="number" placeholder="Enter your User ID" />
            </div>
            <!-- <label class="prompt">Enter your UserID above</label> -->
            <button id="login-button" type="submit" form="login-container"
                value="Submit">Open Account</button>
        </form>
        <label id="footer">Created by <span style="font-weight: 700;">The Humans Trying to Pass (HTTP)</span></label>
    </div>
</body>

</html>