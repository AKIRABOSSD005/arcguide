<?php
require_once '../functions/loginGoogle.php';
$googleLoginUrl = include('../functions/loginGoogle.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ArcGuide</title>
    <link rel="icon" type="image/svg+xml" href="../assets/icons/logo.svg">
    <link rel="stylesheet" href="../assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #f8f5ee 60%, #46b07d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(17, 79, 137, 0.10);
            padding: 2.5rem 2rem;
            max-width: 400px;
            width: 100%;
        }

        .logo-img {
            width: 110px;
            height: 110px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .login-title {
            font-weight: 700;
            color: #114f89;
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #114f89;
            font-weight: 500;
        }

        /* ...existing code... */
        .form-label a.small:hover {
            color: #114f89 !important;
        }

        .btn-login {
            background: #46b07d;
            color: #fff;
            font-weight: 600;
            border: none;
        }

        .btn-login:hover {
            background: #114f89;
            color: #fff;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #aaa;
            position: relative;
        }

        .divider:before,
        .divider:after {
            content: "";
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #e0e0e0;
            vertical-align: middle;
            margin: 0 0.5rem;
        }

        .btn-google {
            background: #fff;
            color: #444;
            border: 1px solid #ddd;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-google img {
            width: 22px;
            height: 22px;
        }

        /* ...existing code...
        .text-center a[href="register.php"]:hover {
            color: #114f89 !important;
            text-decoration: underline !important;
        } */

        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem 0.5rem;
                border-radius: 1rem;
            }

            .logo-img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container mx-auto">
        <div class="text-center">
            <img src="../assets/icons/logo.svg" alt="ArcGuide Logo" class="logo-img">
            <h2 class="login-title">Sign in to ArcGuide</h2>
        </div>
        <form method="POST" action="../functions/login_process.php" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username or Email</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label d-flex justify-content-between align-items-center">
                    Password
                    <a href="#" class="small" style="color:#46b07d; text-decoration:none">Forgot Password?</a>
                </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login w-100 mb-2">Login</button>
        </form>
        <div class="divider">or</div>
        <a href="<?php echo $googleLoginUrl; ?>" class="btn btn-google w-100 mb-3">

            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo">
            Continue with Google
        </a>
    </div>
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>

</html>