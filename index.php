<?php
include "db.php";
session_start();
$sql = "select * from food";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error: {$conn->error}";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        background-color: #f7f7f7;
    }

    /* Navbar */
    .nav {
        background-color: #222;
        display: flex;
        padding: 15px 30px;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .nav a {
        text-decoration: none;
        padding: 8px 15px;
        color: white;
        font-weight: 600;
        border-radius: 5px;
        transition: 0.3s ease;
    }

    .nav a:hover {
        background-color: #ff4757;
        color: #fff;
        transform: scale(1.05);
    }

    .nav ul li {
        list-style: none;
        display: inline-block;
        margin-left: 10px;
    }

    /* Header */
    .header {
        background: linear-gradient(135deg, #ff6b6b, #f06595);
        padding: 40px 20px;
        text-align: center;
        color: white;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .header h1 {
        font-size: 2.2rem;
        margin-bottom: 15px;
    }

    .header p {
        font-size: 1.1rem;
        max-width: 700px;
        margin: auto;
        line-height: 1.5;
    }

    .header hr {
        margin-top: 20px;
        border: none;
        height: 2px;
        background-color: white;
        width: 50%;
    }

    /* Menu Section */
    .sec {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 30px;
        gap: 20px;
    }

    /* Food Card */
    .card {
        background-color: white;
        width: 250px;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.25);
    }

    .card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .card h3 {
        font-size: 1.2rem;
        margin: 8px 0;
        color: #333;
    }

    .card p {
        color: #666;
        font-size: 0.95rem;
    }

    /* Buttons */
    .card a {
        text-decoration: none;
        display: inline-block;
        background-color: #27ae60;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 12px;
        transition: 0.3s ease;
    }

    .card a:hover {
        background-color: #2ecc71;
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sec {
            flex-direction: column;
            align-items: center;
        }

        .card {
            width: 80%;
        }
    }
</style>

<body>
    <nav class="nav">
        <a href="index.php">Home</a>
        <ul>
            <?php if (!isset($_SESSION['user_id'])) { ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php } ?>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <li><a href="user_dashboard.php">Dashboard</a></li>
            <?php } ?>
        </ul>
    </nav>

    <header class="header">
        <h1>Welcome, Order Your Favourite Item!</h1>
        <p>Our menu is crafted with care using fresh ingredients and authentic flavors. Enjoy a variety of dishes that bring taste and happiness to your plate.</p>
        <hr>
        <br>
        <?php
        if (isset($_GET['added_message'])) {
            $message = $_GET['added_message'];
            echo "<h2 style='color:yellow;'>$message</h2>";
        }
        ?>
    </header>

    <section class="sec">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card">
                <img src="image/<?php echo $row['image'] ?>">
                <h3><?php echo $row['food_name'] ?></h3>
                <p>&#8377;<?php echo $row['price'] ?><br>
                    <?php echo $row['category'] ?>
                </p>

                <?php if ($row['stock'] <= 0) { ?>
                    <button style="background: grey; cursor: not-allowed;">Out of Stock</button>
                <?php } else { ?>
                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <a href="login.php">Order Now</a>
                    <?php  } ?>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a href="order_item.php?user_id=<?php echo $_SESSION['user_id']; ?>&menu_id=<?php echo $row['id']; ?>">Buy Now</a>
                    <?php  } ?>
                <?php } ?>
            </div>
        <?php } ?>
    </section>
</body>

</html>