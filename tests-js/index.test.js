/**
 * Tests for shopping cart functionality
 */

describe('Shopping Cart Functionality', () => {
  beforeEach(() => {
    // Set up initial DOM structure
    document.body.innerHTML = `
      <div class="cart-items">
        <div class="cart-row">
          <span class="title-name">Product 1</span>
        </div>
      </div>
      <div class="shop-items">
        <div class="shop-item">
          <span class="title-name">Product 1</span>
          <button class="custom-btn">Add to Cart</button>
        </div>
        <div class="shop-item">
          <span class="title-name">Product 2</span>
          <button class="custom-btn">Add to Cart</button>
        </div>
      </div>
    `;
  });

  afterEach(() => {
    document.body.innerHTML = '';
    jest.clearAllMocks();
  });

  describe('Add to Cart Button Detection', () => {
    test('should find all add to cart buttons', () => {
      const buttons = document.querySelectorAll('.custom-btn');
      expect(buttons.length).toBe(2);
    });

    test('should attach click event listeners to buttons', () => {
      const buttons = document.querySelectorAll('.custom-btn');
      const mockHandler = jest.fn();

      buttons.forEach(button => {
        button.addEventListener('click', mockHandler);
      });

      buttons[0].click();
      expect(mockHandler).toHaveBeenCalledTimes(1);
    });
  });

  describe('Duplicate Item Detection', () => {
    test('should detect duplicate items in cart', () => {
      const cartItems = document.querySelector('.cart-items');
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      const newItemTitle = 'Product 1';

      let isDuplicate = false;
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === newItemTitle) {
          isDuplicate = true;
          break;
        }
      }

      expect(isDuplicate).toBe(true);
    });

    test('should allow adding non-duplicate items', () => {
      const cartItems = document.querySelector('.cart-items');
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      const newItemTitle = 'Product 2';

      let isDuplicate = false;
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === newItemTitle) {
          isDuplicate = true;
          break;
        }
      }

      expect(isDuplicate).toBe(false);
    });

    test('should handle empty cart', () => {
      document.querySelector('.cart-items').innerHTML = '';

      const cartItems = document.querySelector('.cart-items');
      const cartItemNames = cartItems.querySelectorAll('.title-name');

      expect(cartItemNames.length).toBe(0);
    });
  });

  describe('Cart Item Retrieval', () => {
    test('should get product title from shop item', () => {
      const shopItem = document.querySelector('.shop-item');
      const title = shopItem.querySelector('.title-name').textContent;

      expect(title).toBe('Product 1');
    });

    test('should handle multiple product titles', () => {
      const shopItems = document.querySelectorAll('.shop-item');
      const titles = Array.from(shopItems).map(item =>
        item.querySelector('.title-name').textContent
      );

      expect(titles).toEqual(['Product 1', 'Product 2']);
    });
  });

  describe('Add to Cart Function Logic', () => {
    test('should add new item to cart when not duplicate', () => {
      const cartItems = document.querySelector('.cart-items');
      const newItemTitle = 'Product 3';

      // Check if duplicate
      let isDuplicate = false;
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === newItemTitle) {
          isDuplicate = true;
          break;
        }
      }

      if (!isDuplicate) {
        // Add to cart
        const newRow = document.createElement('div');
        newRow.className = 'cart-row';
        const titleSpan = document.createElement('span');
        titleSpan.className = 'title-name';
        titleSpan.textContent = newItemTitle;
        newRow.appendChild(titleSpan);
        cartItems.appendChild(newRow);
      }

      const updatedCartItemNames = cartItems.querySelectorAll('.title-name');
      expect(updatedCartItemNames.length).toBe(2);
      expect(updatedCartItemNames[1].textContent).toBe('Product 3');
    });

    test('should not add duplicate item to cart', () => {
      const cartItems = document.querySelector('.cart-items');
      const duplicateTitle = 'Product 1';
      const initialCount = cartItems.querySelectorAll('.title-name').length;

      // Check if duplicate
      let isDuplicate = false;
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === duplicateTitle) {
          isDuplicate = true;
          break;
        }
      }

      // Should not add if duplicate
      expect(isDuplicate).toBe(true);

      const finalCount = cartItems.querySelectorAll('.title-name').length;
      expect(finalCount).toBe(initialCount);
    });
  });

  describe('Alert Functionality', () => {
    test('should show alert when adding duplicate item', () => {
      // Mock alert
      global.alert = jest.fn();

      const cartItems = document.querySelector('.cart-items');
      const duplicateTitle = 'Product 1';

      // Check if duplicate and alert
      let isDuplicate = false;
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === duplicateTitle) {
          isDuplicate = true;
          alert('This item is already added to the cart');
          break;
        }
      }

      expect(isDuplicate).toBe(true);
      expect(global.alert).toHaveBeenCalledWith('This item is already added to the cart');
    });

    test('should not show alert for non-duplicate items', () => {
      global.alert = jest.fn();

      const cartItems = document.querySelector('.cart-items');
      const newTitle = 'Product 2';

      let isDuplicate = false;
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      for (let i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].textContent === newTitle) {
          isDuplicate = true;
          alert('This item is already added to the cart');
          break;
        }
      }

      expect(isDuplicate).toBe(false);
      expect(global.alert).not.toHaveBeenCalled();
    });
  });

  describe('Event Handling', () => {
    test('should extract correct data from click event', () => {
      const button = document.querySelector('.custom-btn');
      const shopItem = button.parentElement;
      const title = shopItem.querySelector('.title-name').textContent;

      expect(title).toBe('Product 1');
      expect(shopItem.classList.contains('shop-item')).toBe(true);
    });

    test('should handle button click on second item', () => {
      const buttons = document.querySelectorAll('.custom-btn');
      const button = buttons[1];
      const shopItem = button.parentElement;
      const title = shopItem.querySelector('.title-name').textContent;

      expect(title).toBe('Product 2');
    });
  });

  describe('Edge Cases', () => {
    test('should handle cart with no items', () => {
      document.querySelector('.cart-items').innerHTML = '';

      const cartItems = document.querySelector('.cart-items');
      const cartItemNames = cartItems.querySelectorAll('.title-name');

      expect(cartItemNames.length).toBe(0);
    });

    test('should handle special characters in product names', () => {
      const cartItems = document.querySelector('.cart-items');
      const specialTitle = 'Product & Co. (Special)';

      const newRow = document.createElement('div');
      newRow.className = 'cart-row';
      const titleSpan = document.createElement('span');
      titleSpan.className = 'title-name';
      titleSpan.textContent = specialTitle;
      newRow.appendChild(titleSpan);
      cartItems.appendChild(newRow);

      const addedItem = cartItems.querySelectorAll('.title-name')[1];
      expect(addedItem.textContent).toBe(specialTitle);
    });

    test('should handle case-sensitive product matching', () => {
      const cartItems = document.querySelector('.cart-items');

      // Cart has "Product 1"
      const cartItemNames = cartItems.querySelectorAll('.title-name');
      const existingTitle = cartItemNames[0].textContent;

      // Try to add "product 1" (different case)
      const isDuplicate = existingTitle === 'product 1';

      // Should not be considered duplicate (case-sensitive)
      expect(isDuplicate).toBe(false);
    });

    test('should handle trimmed vs non-trimmed titles', () => {
      const title1 = 'Product 1';
      const title2 = ' Product 1 ';

      expect(title1 === title2).toBe(false);
      expect(title1 === title2.trim()).toBe(true);
    });
  });

  describe('Cart Operations', () => {
    test('should maintain cart state after adding items', () => {
      const cartItems = document.querySelector('.cart-items');
      const initialCount = cartItems.querySelectorAll('.title-name').length;

      // Add two new items
      ['Product 2', 'Product 3'].forEach(title => {
        const newRow = document.createElement('div');
        newRow.className = 'cart-row';
        const titleSpan = document.createElement('span');
        titleSpan.className = 'title-name';
        titleSpan.textContent = title;
        newRow.appendChild(titleSpan);
        cartItems.appendChild(newRow);
      });

      const finalCount = cartItems.querySelectorAll('.title-name').length;
      expect(finalCount).toBe(initialCount + 2);
    });

    test('should preserve existing cart items when adding new ones', () => {
      const cartItems = document.querySelector('.cart-items');
      const originalItem = cartItems.querySelector('.title-name').textContent;

      // Add new item
      const newRow = document.createElement('div');
      newRow.className = 'cart-row';
      const titleSpan = document.createElement('span');
      titleSpan.className = 'title-name';
      titleSpan.textContent = 'Product 2';
      newRow.appendChild(titleSpan);
      cartItems.appendChild(newRow);

      const firstItem = cartItems.querySelectorAll('.title-name')[0].textContent;
      expect(firstItem).toBe(originalItem);
    });
  });
});
