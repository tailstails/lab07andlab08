<?php

  /* VALIDATION */
  // Step 1: Create an array to hold all the field errors (replace null with the correct logic)
  
  $errors = [];

  // Step 2: Validate the necessary fields are not empty (add the required fields to the array)
  
  $required_fields = [
    'username',
    'username_confirmation',
    'password',
    'password_confirmation'
  ];
  
  foreach ($required_fields as $field) {
    if (empty($_POST[$field])) { // Step 3: Write the correct condition to check if the field is empty (replace null with the correct logic)
      $human_field = str_replace("_", " ", $field);
      $errors[] = "You cannot leave the {$human_field} blank.";
    }
  }

  // Step 4: Validate the username is in the correct format (replace null with the correct logic)
  
  if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) 
  {
    $errors[] = "The username isn't in a valid format. Please correct it.";
  }

  // Step 5: Validate the username matches the username_confirmation (replace null with the correct logic)
  
  if ($_POST['username'] !== $_POST['username_confirmation']) 
  {
    $errors[] = "The username doesn't match the username confirmation field";
  }

  // Step 6: Validate the password matches the password_confirmation (replace null with the correct logic)
 
  if ($_POST['password'] !== $_POST['password_confirmation']) 
  {
    $errors[] = "The password doesn't match the password confirmation field";
  }
  
  // Step 7: Check if they're errors (replace null with the correct logic)
  if (count($errors) > 0) 
  {
    // Add the current form values to the $_SESSION
    session_start();
    $_SESSION['form_values'] = $_POST;
    
    // Store the errors
    $_SESSION['errors'] = $errors;
    
    // Redirect back to the form and exit
    header('Location: ./register.php');
    exit;
  }
  /* END OF VALIDATION */

  /* NORMALIZATION */
  // Normalize the string fields (convert to lowercase and capitalize the first letter)
  foreach (['first_name', 'last_name'] as $field) 
  {
    $_POST[$field] = strtolower($_POST[$field]);
    $_POST[$field] = ucwords($_POST[$field]);
  }

  // Step 8: Lowercase the username (replace null with the correct logic)
  $_POST['username'] = strtolower($_POST['username']);

  // Step 9: Hash the password (replace null with the correct logic)
  $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
  /* END NORMALIZATION */

  /* SANITIZATION */
  // Sanitize all values on their insertion
  require_once('_connect.php');
  $conn = connect();

  // Step 10: Write the correct SQL statement that will insert the new user (you must bind the parameters (placeholders)) (replace null with the correct logic)
  $sql = "INSERT INTO users (
    username,
    password
) VALUES (
    '{$_POST[':username']}',
    {$_POST[':password']}
)";

  $stmt = $conn->prepare($sql);

  // Step 11: Sanitize by binding the values to the parameters (placeholders) (replace null with the correct logic)
  $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  $stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
  /* END SANITIZATION */

  // Insert our row
  $stmt->execute();

  // Check for errors
  session_start();
  if ($stmt->errorCode() === "23000") {
    $_SESSION['errors'][] = "You have already registered. Please login.";
    $_SESSION['form_values'] = $_POST;
  } else if ($stmt->errorCode() !== "00000") {
    // Add the error message to the errors session array
    $_SESSION['errors'][] = "There was an error during registration.";
    $_SESSION['form_values'] = $_POST;
  } else {
    // Add the success message to the successes session array
    $_SESSION['successes'][] = "You have been registered successfully.";
    header('Location: ./login.php');
    exit;
  }

  // Redirect back to the form
  header('Location: ./register.php');
  exit;