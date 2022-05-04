<?php
session_start();
if (isset($_SESSION['User'])) {
    if ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "A") {
        header("Location: eleve.php");
    } else {
        header("Location: download.php");
    }
} else {

    echo
    '<html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

            <title>Login Form</title>
        </head>
        <body >

        <div class="container">
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card bg-dark mt-5 ">
                        <div class="card-title bg-dark text-white mt-5">

                                <h3 class="text-center py-3">Login</h3>
                            </div>
                            <div class="card-body">
                                <form action="process.php" method="post">
                                    <input type="text" name="username" placeholder=" UserName" class="form-control mb-3">
                                    <input type="password" name="Password" placeholder=" Password" class="form-control mb-3">
                                    <button class="btn btn-success mt-5" name="Login">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        </html>';
}
