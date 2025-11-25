<?php

namespace App\Services;

/**
 * Order Service
 * Handles order processing
 */
class OrderService
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    /**
     * Create an order
     * @param array $orderData Order information
     * @param array $cart Shopping cart items
     * @return array ['success' => bool, 'orderId' => int, 'error' => string]
     */
    public function createOrder($orderData, $cart)
    {
        // Validate order data
        $validation = $this->validateOrderData($orderData);
        if (!$validation['valid']) {
            return ['success' => false, 'error' => $validation['error']];
        }

        // Validate cart
        if (empty($cart) || !is_array($cart)) {
            return ['success' => false, 'error' => 'Cart is empty'];
        }

        // Calculate total
        $cartService = new ShoppingCartService();
        $total = $cartService->calculateTotal($cart);

        if ($total <= 0) {
            return ['success' => false, 'error' => 'Invalid cart total'];
        }

        // Prepare order items as JSON
        $orderItems = json_encode($cart);

        // Insert order using prepared statement
        $stmt = $this->db->prepare(
            "INSERT INTO orders (user_email, full_name, phone, address, pincode, order_items, total_amount, order_date)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
        );

        if (!$stmt) {
            return ['success' => false, 'error' => 'Database error'];
        }

        $stmt->bind_param(
            "ssssssd",
            $orderData['email'],
            $orderData['name'],
            $orderData['phone'],
            $orderData['address'],
            $orderData['pincode'],
            $orderItems,
            $total
        );

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;
            $stmt->close();
            return ['success' => true, 'orderId' => $orderId];
        }

        $error = $stmt->error;
        $stmt->close();
        return ['success' => false, 'error' => 'Failed to create order: ' . $error];
    }

    /**
     * Validate order data
     * @param array $orderData
     * @return array ['valid' => bool, 'error' => string]
     */
    public function validateOrderData($orderData)
    {
        $required = ['name', 'email', 'phone', 'address', 'pincode'];

        foreach ($required as $field) {
            if (empty($orderData[$field])) {
                return ['valid' => false, 'error' => ucfirst($field) . ' is required'];
            }
        }

        // Validate email
        if (!filter_var($orderData['email'], FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'error' => 'Invalid email format'];
        }

        // Validate phone (basic validation for 10 digits)
        if (!preg_match('/^\d{10}$/', $orderData['phone'])) {
            return ['valid' => false, 'error' => 'Phone number must be 10 digits'];
        }

        // Validate pincode (6 digits)
        if (!preg_match('/^\d{6}$/', $orderData['pincode'])) {
            return ['valid' => false, 'error' => 'Pincode must be 6 digits'];
        }

        // Validate name (at least 2 characters, letters and spaces only)
        if (strlen($orderData['name']) < 2 || !preg_match('/^[a-zA-Z\s]+$/', $orderData['name'])) {
            return ['valid' => false, 'error' => 'Invalid name format'];
        }

        // Validate address (at least 10 characters)
        if (strlen($orderData['address']) < 10) {
            return ['valid' => false, 'error' => 'Address must be at least 10 characters'];
        }

        return ['valid' => true];
    }

    /**
     * Get orders by user email
     * @param string $email
     * @return array Orders
     */
    public function getOrdersByEmail($email)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM orders WHERE user_email = ? ORDER BY order_date DESC"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $row['order_items'] = json_decode($row['order_items'], true);
            $orders[] = $row;
        }

        $stmt->close();
        return $orders;
    }

    /**
     * Get order by ID
     * @param int $orderId
     * @return array|null Order data or null if not found
     */
    public function getOrderById($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        $order = $result->fetch_assoc();
        if ($order) {
            $order['order_items'] = json_decode($order['order_items'], true);
        }

        $stmt->close();
        return $order;
    }
}
