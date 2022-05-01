<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workstation</title>
    <link rel="shortcut icon" href="./resources/img/folder.svg" type="image/x-icon">
    <link rel="stylesheet" href="./resources/bootstrap/css/bootstrap.min.css">
    <?php 
        include('./includes/header.php'); ;
        session_start();
        if(!isset($_SESSION['login_id']))
            header('location:login.php');
    ?>
</head>
<body>
    <div class="workstation">

        <!-- ---------------------------------NAVBAR------------------------------------ -->

        <?php include('./includes/navbar.php'); ?>

        <!-- -------------------------------------BODY------------------------------------------- -->


        <div class="row body">

            <!-- -----------------------------------------SIDEBAR-------------------------------------------- -->


            <?php include("./includes/sidebar.php"); ?>

            <!-- ----------------------------------------------PAGE-------------------------------------------------- -->


            <div class="col-12 col-md-9 page">
                <?php 
                    $page = isset($_GET['page']) ? $_GET['page'] :'files';
                    include './includes/'.$page.'.php';
                ?>
            </div>
            
        </div>

        <!-- --------------------------------MODEL------------------------------------ -->

        <?php include "./includes/model.php"; ?>

        
    </div>
    <script src="./resources/jquery/index.js"></script>
</body>
</html>