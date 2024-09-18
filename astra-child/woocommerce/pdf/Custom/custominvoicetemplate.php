<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$order = wc_get_order( $order_id );

if ( ! $order ) {
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>
<body>

    <div class="invoice-header">
        <h1>Invoice</h1>
        <p>Invoice Number: <?php echo $order->get_order_number(); ?></p>
        <p>Date: <?php echo wc_format_datetime( $order->get_date_created() ); ?></p>
    </div>

    <div class="invoice-details">
        <h2>Order Details</h2>
        <p><strong>Customer:</strong> <?php echo $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(); ?></p>
        <p><strong>Address:</strong> <?php echo $order->get_billing_address_1() . ', ' . $order->get_billing_city() . ', ' . $order->get_billing_postcode(); ?></p>
        <p><strong>Email:</strong> <?php echo $order->get_billing_email(); ?></p>
    </div>

    <table class="invoice-items">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $order->get_items() as $item_id => $item ) : ?>
                <tr>
                    <td><?php echo $item->get_name(); ?></td>
                    <td><?php echo $item->get_quantity(); ?></td>
                    <td><?php echo wc_price( $item->get_subtotal() / $item->get_quantity() ); ?></td>
                    <td><?php echo wc_price( $item->get_total() ); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="invoice-summary">
        <p><strong>Subtotal:</strong> <?php echo wc_price( $order->get_subtotal() ); ?></p>
        <p><strong>Shipping:</strong> <?php echo wc_price( $order->get_shipping_total() ); ?></p>
        <p><strong>Total:</strong> <?php echo wc_price( $order->get_total() ); ?></p>
    </div>

</body>
</html>
