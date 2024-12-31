<?php
session_start();
require_once '../common/db.php'; // Include database connection
require_once '../common/stripe-php/stripe-php-master/init.php'; // Include Stripe library

\Stripe\Stripe::setApiKey('sk_test_51QONCRLlhzgiXt9ujd9WG8Nfn882nnWRyyqeXvmX997QrR5ZgreCwE66olUyIVuBhMcgXYBw9CTuKJIOjjUz9Ott00l44Xan75'); // Your Stripe Secret Key

// Retrieve booking ID from query
if (!isset($_GET['booking_id'])) {
    echo "Invalid booking ID.";
    exit;
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$sql = "SELECT * FROM bookings WHERE booking_id = ? AND status = 'Confirmed' AND payment_status = 'Pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $booking_id);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    echo "Invalid or already paid booking.";
    exit;
}

// Replace with actual amount calculation logic
$amount = 10000; // Example: $100.00 (Stripe expects amounts in cents)

// Create a Stripe Checkout session
try {
    $checkoutSession = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'], // Accept card payments
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Booking Payment',
                    'description' => "Payment for booking ID: $booking_id",
                ],
                'unit_amount' => $amount, // Amount in cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/travelagency2.6/customer/payment_success.php?booking_id=' . $booking_id,
        'cancel_url' => 'http://localhost/travelagency2.6/customer/payment_cancel.php?booking_id=' . $booking_id,
    ]);

    // Redirect the user to the Checkout page
    header('Location: ' . $checkoutSession->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    echo "Error creating checkout session: " . $e->getMessage();
    exit;
}
?>
