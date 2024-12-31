<?php
    session_start();  // Start the session

    // Destroy all session data
    session_destroy();

    // Redirect to homepage
    header("Location: index.php");
    exit;
?>
