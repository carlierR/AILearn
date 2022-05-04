<?php
session_start();
if ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "A") {

    header("location:eleve.php");
} elseif ($_SESSION['User'][0] == "P" and $_SESSION['User'][1] == "E") {
    echo
    '<html
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <title> Form</title>
            <style>
            .btn {
                background-color: DodgerBlue;
                border: none;
                color: white;
                padding: 12px 30px;
                cursor: pointer;
                font-size: 20px;
            }

            /* Darker background on mouse-over */
            .btn:hover {
            background-color: RoyalBlue;
            }
            </style>
        </head>
        <body >
        <div class="container">
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card bg-dark mt-5 ">
                        <div class="card-title bg-dark text-white mt-5">
                                <h3 class="text-center py-3">Télcharger le fichier excel</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 text-center">
                                    <a href="./recuperation.php"><button class="btn text-center"><i class="fa fa-download "></i> Download</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        </body>
        </html>';
} else {
    echo '<a href="login.php">Login</a>';
}
