<?php
  session_start();

  // If they're not logged in, redirect them
  if (!isset($_SESSION['user'])) {
    $_SESSION['errors'][] = "You must log in";
    header('Location: ./login.php');
    exit;
  }

  // Assign the user
  $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

    <title>Profile</title>
  </head>

  <body>
    <?php include_once('notification.php') ?>

    <div class="container">
      <header class="jumbotron my-5">
        <div class="row">
          <div class="col-5">
            <img src="http://api.adorable.io/avatars/300/<?= $user['username'] ?>" alt="Your avatar self." class="img-fluid img-thumbnail">
          </div>

          <div class="col-7">
            <h1 class="display-4">Hello <strong><?= "{$user['username']}" ?></strong></h1>
            <hr class="my-4">
            <p>
              YOU HAVE SUCCESSFULLY COMPLETED YOUR LAB!
            </p>
          </div>
        </div>
      </header>

      <a class="btn" href="logout.php">Logout</a>
    </div>
  </body>
</html>