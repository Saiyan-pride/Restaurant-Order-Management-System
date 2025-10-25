<?php
include "db.php";
$message = "";
if (isset($_POST['click'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "select * from `user` where email = '$email'";

    try {
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) {
            $message = "<h3 style = 'position: fixed;
                                        left: 39%;
                                        top: 7%;
                                        font-family: Times;
                                        color: red;'>
                                        user not found, please register!
                                        </h3>";
        } elseif ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] == $password) {


                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = $row['type'];

                if ($_SESSION['user_id']) {
                    if ($_SESSION['user_type'] == "admin") {
                        header("Location: admin/admin_dashboard.php");
                    }
                    if ($_SESSION['user_type'] == "user") {
                        header("Location: index.php");
                    }
                }
            } else {
                $message =  "<h3 style = 'position: fixed;
                                        left: 44%;
                                        top: 7%;
                                        font-family: Times;
                                        color: red;'>
                                        wrong password!
                                        </h3>";
            }
        }
    } catch (mysqli_sql_exception) {
        $message = "Couldn't connect to the server";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form {
            background: rgba(222, 234, 238, 1);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
            margin-top: 20px;
        }

        .form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .form input:focus {
            border-color: #4a90e2;
            box-shadow: 0px 0px 8px rgba(74, 144, 226, 0.5);
        }

        .btn {
            background: #4a90e2 !important;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            padding: 12px;
        }

        .btn:hover {
            background: #357ABD !important;
        }

        .form p {
            margin-top: 15px;
            font-size: 14px;
            color: #333;
        }

        .form a {
            text-decoration: none;
            color: #4a90e2;
            font-weight: bold;
            transition: 0.3s;
        }

        .form a:hover {
            color: #357ABD;
        }
    </style>
</head>

<body>
    <?php if($message!=""){
        echo $message;
    } ?>
    <form class="form" action="login.php" method="post">
        Enter your email:
        <input type="email" name="email" required>
        Enter your password:
        <input type="password" name="password" required>
        <input class="btn" type="submit" name="click" value="Login">
        <hr>
        <p>Go for Registration:
            <a href="register.php">Register</a>
        </p>
    </form>
</body>

</html>