<?php
session_start();

// If already logged in, redirect to admin dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senior Citizen Information Management System</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="asset/fontawesome/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Background */
        .login-page {
            background: linear-gradient(45deg, #BB1900, #FD6F01, #FFB000);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Source Sans Pro', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Card container */
        .login-box {
            width: 400px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            z-index: 1; /* To make sure it's above the floating boxes */
        }

        /* Logo and header */
        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header img {
            width: 150px;
            margin-bottom: 10px;
        }

        /* Form styling */
        .form-control {
            border-radius: 10px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 16px;
            box-shadow: none;
        }

        .input-group-text {
            border-radius: 0 10px 10px 0;
            background-color: transparent;
            border: 1px solid #ced4da;
            border-left: none;
            font-size: 18px;
        }

        /* Button */
        .btn-bg {
            background-color: #FD6F01;
            color: white;
            padding: 12px 0;
            font-size: 18px;
            border-radius: 10px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-bg:hover {
            background-color: #FF8C33;
        }

        /* Error message */
        .alert-danger {
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
        }

        /* Floating boxes */
        .floating-box {
            position: absolute;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            animation: float 6s infinite ease-in-out;
            opacity: 0; /* Start off invisible */
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0; /* Start invisible */
            }
            25% {
                opacity: 1; /* Gradually fade in */
            }
            50% {
                transform: translateY(-20px) rotate(45deg);
                opacity: 0.8;
            }
            75% {
                opacity: 1; /* Full visibility before fading */
            }
            100% {
                transform: translateY(0) rotate(90deg);
                opacity: 0; /* Gradually fade out */
            }
        }

        /* Responsive behavior */
        @media (max-width: 576px) {
            .login-box {
                width: 90%;
                padding: 15px;
            }
        }
    </style>
</head>
<body class="hold-transition login-page">
    <!-- Container for dynamically added boxes -->
    <div id="box-container"></div>

    <div class="login-box">
        <div class="card-header">
            <a href="index.php">
                <img src="asset/img/osca logo.png" alt="DSMS Logo">
            </a>
        </div>
        <div class="card-body">
            <form action="login_action.php" method="post">
                <div class="input-group mb-4">
                    <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <!-- Display error message if login failed -->
                <?php
                if (isset($_GET['error'])) {
                    echo "<div class='alert alert-danger text-center'>" . htmlspecialchars($_GET['error']) . "</div>";
                }
                ?>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-bg btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to generate random numbers within a range
        function random(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Function to create a new floating box
        function createBox() {
            const boxContainer = document.getElementById('box-container');
            const box = document.createElement('div');
            box.classList.add('floating-box');

            // Random position for the box
            box.style.top = random(0, 80) + '%';
            box.style.left = random(0, 80) + '%';

            // Random animation duration and delay
            const duration = random(5, 10) + 's';
            const delay = random(0, 5) + 's';
            box.style.animationDuration = duration;
            box.style.animationDelay = delay;

            // Append box to the container
            boxContainer.appendChild(box);

            // Remove the box from the DOM after its animation ends
            box.addEventListener('animationend', () => {
                box.remove();
            });
        }

        // Generate new boxes every 1 second
        setInterval(createBox, 1000);
    </script>
</body>
</html>
