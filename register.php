<?php
include "db.php";
$message = "";
if (isset($_POST['btn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = "user";
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $sql = "insert into user(
        id, name, email, password, type, address, phone) values (
        null, '$name', '$email', '$password', '$type', '$address', '$phone')";

    try {
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $message = "<div class='msg error'>Error!: {$conn->error}</div>";
        } else {
            $message = "<div class='msg success'>Registered Successfully!</div>";
        }
    } catch (mysqli_sql_exception) {
        $message = "<div class='msg error'>You are already registered</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style type="text/css">
        body {
            margin: 20px;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f7f7f7;
        }

        .form {
            background: #fff;
            padding: 20px 40px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            
        }

        /* Message styling */
        .msg {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            font-size: 15px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form input,
        .form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
            background: #fafafa;
        }

        .form input:focus,
        .form textarea:focus {
            border-color: #4a90e2;
            box-shadow: 0px 0px 8px rgba(2, 2, 3, 0.4);
            background: #fff;
        }

        .textarea {
            resize: none;
            height: 100px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #4a90e2 !important;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #357ABD !important;
        }

        .form a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        .form a:hover {
            color: #357ABD;
        }
    </style>
</head>

<body>
    <form class="form" action="register.php" method="post">
        <?php
        if ($message != "") {
            echo $message;
        }
        ?>
        Enter your name:
        <input type="text" name="name" required>
        Enter your email:
        <input type="email" name="email" required>
        Enter your password:
        <input type="password" name="password" required>
        Enter your address:
        <textarea class="textarea" name="address"></textarea>
        Enter your phone number:
        <input type="text" name="phone" required>
        <input type="submit" name="btn" value="Sign up" class="btn" required>
        <hr>
        <p>Go for Login: <a href="login.php">Login</a></p>
    </form>
</body>

</html>