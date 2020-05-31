<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="logo/favicon-1.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h1>Login</h1>
            </div>
            <div class="card-body">
                <form action="proses_login_customer.php" method="post">
                    Username
                    <input type="text" name="username" id="username" class="form-control" required />
                    Password
                    <input type="password" name="password" id="password" class="form-control" required />
                    <br>
                    <button type="submit" name="login_customer" class="btn btn-block btn-dark">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>