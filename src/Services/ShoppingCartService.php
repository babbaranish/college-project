<?php

namespace App\Services;

/**
 * Shopping Cart Service
 * Handles shopping cart operations
 */
class ShoppingCartService
{
    /**
     * Add item to cart
     * @param array $cart Current cart array
     * @param string $itemId
     * @param string $itemName
     * @param string $itemImage
     * @param float $itemPrice
     * @param int $quantity
     * @return array Updated cart
     */
    public function addItem($cart, $itemId, $itemName, $itemImage, $itemPrice, $quantity = 1)
    {
        if (!is_array($cart)) {
            $cart = [];
        }

        // Validate inputs
        if (empty($itemId) || empty($itemName) || $itemPrice <= 0 || $quantity <= 0) {
            throw new \InvalidArgumentException('Invalid item data');
        }

        // Check if item already exists in cart
        $existingIndex = $this->findItemIndex($cart, $itemId);

        if ($existingIndex !== false) {
            // Item exists, increment quantity
            $cart[$existingIndex]['item_quantity'] += $quantity;
        } else {
            // New item, add to cart
            $cart[] = [
                'item_id' => $itemId,
                'item_name' => $itemName,
                'item_img' => $itemImage,
                'item_price' => (float)$itemPrice, // Store unit price
                'item_quantity' => (int)$quantity
            ];
        }

        return $cart;
    }

    /**
     * Remove item from cart
     * @param array $cart Current cart array
     * @param string $itemId
     * @return array Updated cart
     */
    public function removeItem($cart, $itemId)
    {
        if (!is_array($cart)) {
            return [];
        }

        $index = $this->findItemIndex($cart, $itemId);
        if ($index !== false) {
            unset($cart[$index]);
            // Re-index array
            $cart = array_values($cart);
        }

        return $cart;
    }

    /**
     * Update item quantity
     * @param array $cart Current cart array
     * @param string $itemId
     * @param int $quantity
     * @return array Updated cart
     */
    public function updateQuantity($cart, $itemId, $quantity)
    {
        if (!is_array($cart)) {
            return [];
        }

        if ($quantity <= 0) {
            return $this->removeItem($cart, $itemId);
        }

        $index = $this->findItemIndex($cart, $itemId);
        if ($index !== false) {
            $cart[$index]['item_quantity'] = (int)$quantity;
        }

        return $cart;
    }

    /**
     * Calculate cart total
     * @param array $cart
     * @return float Total price
     */
    public function calculateTotal($cart)
    {
        if (!is_array($cart) || empty($cart)) {
            return 0.0;
        }

        $total = 0.0;
        foreach ($cart as $item) {
            if (isset($item['item_price']) && isset($item['item_quantity'])) {
                // Always use unit price * quantity for calculation
                $total += (float)$item['item_price'] * (int)$item['item_quantity'];
            }
        }

        return round($total, 2);
    }

    /**
     * Get item count in cart
     * @param array $cart
     * @return int
     */
    public function getItemCount($cart)
    {
        if (!is_array($cart)) {
            return 0;
        }

        return count($cart);
    }

    /**
     * Get total quantity of all items
     * @param array $cart
     * @return int
     */
    public function getTotalQuantity($cart)
    {
        if (!is_array($cart)) {
            return 0;
        }

        $totalQuantity = 0;
        foreach ($cart as $item) {
            if (isset($item['item_quantity'])) {
                $totalQuantity += (int)$item['item_quantity'];
            }
        }

        return $totalQuantity;
    }

    /**
     * Clear the cart
     * @return array Empty cart
     */
    public function clearCart()
    {
        return [];
    }

    /**
     * Find item index in cart by ID
     * @param array $cart
     * @param string $itemId
     * @return int|false Index or false if not found
     */
    private function findItemIndex($cart, $itemId)
    {
        foreach ($cart as $index => $item) {
            if (isset($item['item_id']) && $item['item_id'] === $itemId) {
                return $index;
            }
        }
        return false;
    }

    /**
     * Validate cart data structure
     * @param array $cart
     * @return bool
     */
    public function isValidCart($cart)
    {
        if (!is_array($cart)) {
            return false;
        }

        foreach ($cart as $item) {
            if (!isset($item['item_id'], $item['item_name'], $item['item_price'], $item['item_quantity'])) {
                return false;
            }

            if ($item['item_price'] <= 0 || $item['item_quantity'] <= 0) {
                return false;
            }
        }

        return true;
    }
}
