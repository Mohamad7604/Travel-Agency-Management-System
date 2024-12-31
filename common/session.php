<?php
    session_start();
    
    // Function to check if user is logged in
    function check_login($role) {
        if ($role == 'agent') {
            if (!isset($_SESSION['agent_id'])) {
                header("Location: ../agent/agent_login.php");
                exit;
            }
        } else if ($role == 'customer') {
            if (!isset($_SESSION['customer_id'])) {
                header("Location: ../customer/customer_login.php");
                exit;
            }
        }
    }
?>
