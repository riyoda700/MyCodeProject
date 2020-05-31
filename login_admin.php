<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
     <script src="../assets/js/jquery.min.js"></script>
     <script src="../assets/js/popper.min.js"></script>
     <script src="../assets/js/bootstrap.js"></script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4>Toko Buku</h4>
            </div>
            <div class="card-body">
                <form action="proses_login_admin.php" method="post">
                    Username
                    <input type="text" name="username" id="username" class="form-control" required />
                    Password
                    <input type="password" name="password" id="password" class="form-control" required />
                    <br>
                    <button type="submit" name="login_admin" class="btn btn-block btn-dark">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>