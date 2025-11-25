<?php

namespace App\Services;

/**
 * Product Service
 * Handles product CRUD operations
 */
class ProductService
{
    private $db;
    private $validCategories = ['hats', 'jackets', 'mens', 'womens', 'sneakers'];

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    /**
     * Add a new product
     * @param string $category
     * @param string $productName
     * @param float $price
     * @param string $imagePath
     * @return array ['success' => bool, 'productId' => int, 'error' => string]
     */
    public function addProduct($category, $productName, $price, $imagePath)
    {
        // Validate inputs
        if (!$this->isValidCategory($category)) {
            return ['success' => false, 'error' => 'Invalid category'];
        }

        if (empty($productName) || strlen($productName) < 2) {
            return ['success' => false, 'error' => 'Product name must be at least 2 characters'];
        }

        if ($price <= 0) {
            return ['success' => false, 'error' => 'Price must be greater than 0'];
        }

        if (empty($imagePath)) {
            return ['success' => false, 'error' => 'Image path is required'];
        }

        // Insert product
        $stmt = $this->db->prepare("INSERT INTO $category (product, price, image) VALUES (?, ?, ?)");

        if (!$stmt) {
            return ['success' => false, 'error' => 'Database error'];
        }

        $stmt->bind_param("sds", $productName, $price, $imagePath);

        if ($stmt->execute()) {
            $productId = $stmt->insert_id;
            $stmt->close();
            return ['success' => true, 'productId' => $productId];
        }

        $error = $stmt->error;
        $stmt->close();
        return ['success' => false, 'error' => 'Failed to add product: ' . $error];
    }

    /**
     * Remove a product
     * @param string $category
     * @param int $productId
     * @return array ['success' => bool, 'error' => string]
     */
    public function removeProduct($category, $productId)
    {
        if (!$this->isValidCategory($category)) {
            return ['success' => false, 'error' => 'Invalid category'];
        }

        if ($productId <= 0) {
            return ['success' => false, 'error' => 'Invalid product ID'];
        }

        $stmt = $this->db->prepare("DELETE FROM $category WHERE id = ?");

        if (!$stmt) {
            return ['success' => false, 'error' => 'Database error'];
        }

        $stmt->bind_param("i", $productId);

        if ($stmt->execute()) {
            $affectedRows = $stmt->affected_rows;
            $stmt->close();

            if ($affectedRows > 0) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Product not found'];
            }
        }

        $error = $stmt->error;
        $stmt->close();
        return ['success' => false, 'error' => 'Failed to remove product: ' . $error];
    }

    /**
     * Get product by ID
     * @param string $category
     * @param int $productId
     * @return array|null Product data or null
     */
    public function getProduct($category, $productId)
    {
        if (!$this->isValidCategory($category)) {
            return null;
        }

        $stmt = $this->db->prepare("SELECT * FROM $category WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        return $product;
    }

    /**
     * Get all products in a category
     * @param string $category
     * @param int $limit Optional limit
     * @param int $offset Optional offset
     * @return array Products
     */
    public function getProductsByCategory($category, $limit = null, $offset = 0)
    {
        if (!$this->isValidCategory($category)) {
            return [];
        }

        $query = "SELECT * FROM $category";

        if ($limit !== null) {
            $query .= " LIMIT ? OFFSET ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ii", $limit, $offset);
        } else {
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        $stmt->close();
        return $products;
    }

    /**
     * Update product
     * @param string $category
     * @param int $productId
     * @param array $data ['product' => string, 'price' => float, 'image' => string]
     * @return array ['success' => bool, 'error' => string]
     */
    public function updateProduct($category, $productId, $data)
    {
        if (!$this->isValidCategory($category)) {
            return ['success' => false, 'error' => 'Invalid category'];
        }

        if ($productId <= 0) {
            return ['success' => false, 'error' => 'Invalid product ID'];
        }

        $updates = [];
        $params = [];
        $types = '';

        if (isset($data['product'])) {
            $updates[] = "product = ?";
            $params[] = $data['product'];
            $types .= 's';
        }

        if (isset($data['price'])) {
            if ($data['price'] <= 0) {
                return ['success' => false, 'error' => 'Price must be greater than 0'];
            }
            $updates[] = "price = ?";
            $params[] = $data['price'];
            $types .= 'd';
        }

        if (isset($data['image'])) {
            $updates[] = "image = ?";
            $params[] = $data['image'];
            $types .= 's';
        }

        if (empty($updates)) {
            return ['success' => false, 'error' => 'No data to update'];
        }

        $params[] = $productId;
        $types .= 'i';

        $query = "UPDATE $category SET " . implode(', ', $updates) . " WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            return ['success' => false, 'error' => 'Database error'];
        }

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true];
        }

        $error = $stmt->error;
        $stmt->close();
        return ['success' => false, 'error' => 'Failed to update product: ' . $error];
    }

    /**
     * Validate category
     * @param string $category
     * @return bool
     */
    public function isValidCategory($category)
    {
        return in_array($category, $this->validCategories);
    }

    /**
     * Get all valid categories
     * @return array
     */
    public function getValidCategories()
    {
        return $this->validCategories;
    }

    /**
     * Validate image file
     * @param array $file $_FILES array element
     * @return array ['valid' => bool, 'error' => string]
     */
    public function validateImageFile($file)
    {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['valid' => false, 'error' => 'No file uploaded'];
        }

        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'error' => 'File upload error'];
        }

        // Check file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            return ['valid' => false, 'error' => 'File size must be less than 5MB'];
        }

        // Check if it's actually an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return ['valid' => false, 'error' => 'File must be an image (JPEG, PNG, GIF, or WebP)'];
        }

        // Check image dimensions (optional, prevents upload of fake images)
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            return ['valid' => false, 'error' => 'Invalid image file'];
        }

        return ['valid' => true];
    }
}
