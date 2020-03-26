<?php

  /*
    LAB 07:
      Table name: members
      Fields:
        username (unique)
        password
  */

  // Connect to the database
  require('./_connect.php');
  $conn = connect();
  
  // Step 1: Create our SQL with an username placeholder (bound parameter)
  
  $sql = "SELECT * FROM members WHERE username = :username";
  
  // Step 2: Prepare the SQL (replace null with the correct logic)
  
  $stmt = $conn->prepare($sql);
  
  // Step 3: Bind the value to the placeholder (incidently this will also sanitize the value) (replace null with the correct logic)
  
  $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  
  // Execute
  $stmt->execute();
  
  // Check for errors
  session_start();
  if ($stmt->errorCode() !== "00000") {
    // Add the error message to the errors session array
    $_SESSION['errors'][] = "You could not be authenticated. Check your username address or please register for an account.";
    $_SESSION['form_values'] = $_POST;

    // Redirect back to the form
    header('Location: ./login.php');
    exit;
  }

  // Step 4: Fetch the user (replace null with the correct logic)
  $user = $stmt->fetch();
  if (!$user || password_verify($_POST['password'], $user['password'])) { // Step 5: Add to the condition a check that will verify if the password is correct
    // Add the error message to the errors session array
    $_SESSION['errors'][] = "You could not be authenticated. Check your username address or please register for an account.";
    $_SESSION['form_values'] = $_POST;

    // Redirect back to the form
    header('Location: ./login.php');
    exit;
  }

  // Add a session variable to keep track of the user
  unset($user['password']);
  $_SESSION['user'] = $user;

  // Redirect back to the form
  $_SESSION['successes'][] = "You have successfully logged in.";
  header('Location: ./profile.php');
  exit;