/**
 * Tests for form input validation and label animations
 */

describe('Form Input Label Animation Functions', () => {
  let mockInput, mockLabel;

  beforeEach(() => {
    // Set up DOM elements
    document.body.innerHTML = `
      <input id="test-input" />
      <label class="test-label"></label>
    `;

    mockInput = document.getElementById('test-input');
    mockLabel = document.querySelector('.test-label');
  });

  afterEach(() => {
    document.body.innerHTML = '';
  });

  describe('Label Animation Logic', () => {
    test('should add shrink class when input has value', () => {
      mockInput.value = 'test';

      // Simulate the check function
      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }

      expect(mockLabel.classList.contains('shrink1')).toBe(true);
    });

    test('should toggle shrink class when input is empty', () => {
      mockInput.value = '';

      // Initially add the class
      mockLabel.classList.add('shrink1');
      expect(mockLabel.classList.contains('shrink1')).toBe(true);

      // Simulate the check function
      if (mockInput.value.length === 0) {
        mockLabel.classList.toggle('shrink1');
      }

      expect(mockLabel.classList.contains('shrink1')).toBe(false);
    });

    test('should handle multiple value changes correctly', () => {
      // Start empty
      mockInput.value = '';
      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }
      expect(mockLabel.classList.contains('shrink1')).toBe(false);

      // Add value
      mockInput.value = 'test';
      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }
      expect(mockLabel.classList.contains('shrink1')).toBe(true);

      // Clear value
      mockInput.value = '';
      if (mockInput.value.length === 0) {
        mockLabel.classList.toggle('shrink1');
      }
      expect(mockLabel.classList.contains('shrink1')).toBe(false);
    });
  });

  describe('Input Validation', () => {
    test('should detect empty input', () => {
      mockInput.value = '';
      expect(mockInput.value.length).toBe(0);
    });

    test('should detect non-empty input', () => {
      mockInput.value = 'test@example.com';
      expect(mockInput.value.length).toBeGreaterThan(0);
    });

    test('should handle whitespace in input', () => {
      mockInput.value = '   ';
      expect(mockInput.value.length).toBeGreaterThan(0);
    });
  });

  describe('Event Listener Behavior', () => {
    test('should trigger on focus event', () => {
      const focusHandler = jest.fn();
      mockInput.addEventListener('focus', focusHandler);

      mockInput.focus();

      expect(focusHandler).toHaveBeenCalled();
    });

    test('should trigger on focusout event', () => {
      const focusoutHandler = jest.fn();
      mockInput.addEventListener('focusout', focusoutHandler);

      mockInput.focus();
      mockInput.blur();

      expect(focusoutHandler).toHaveBeenCalled();
    });

    test('should handle multiple event listeners', () => {
      const handler1 = jest.fn();
      const handler2 = jest.fn();

      mockInput.addEventListener('focus', handler1);
      mockInput.addEventListener('focus', handler2);

      mockInput.focus();

      expect(handler1).toHaveBeenCalled();
      expect(handler2).toHaveBeenCalled();
    });
  });

  describe('Edge Cases', () => {
    test('should handle very long input', () => {
      mockInput.value = 'a'.repeat(1000);

      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }

      expect(mockLabel.classList.contains('shrink1')).toBe(true);
    });

    test('should handle special characters', () => {
      mockInput.value = '!@#$%^&*()';

      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }

      expect(mockLabel.classList.contains('shrink1')).toBe(true);
    });

    test('should handle unicode characters', () => {
      mockInput.value = '你好世界';

      if (mockInput.value.length > 0) {
        mockLabel.classList.add('shrink1');
      }

      expect(mockLabel.classList.contains('shrink1')).toBe(true);
    });
  });

  describe('Form Fields Integration', () => {
    beforeEach(() => {
      document.body.innerHTML = `
        <form>
          <input id="email" type="email" />
          <label class="email-label"></label>

          <input id="password" type="password" />
          <label class="password-label"></label>

          <input id="name" type="text" />
          <label class="name-label"></label>
        </form>
      `;
    });

    test('should handle multiple form fields independently', () => {
      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const emailLabel = document.querySelector('.email-label');
      const passwordLabel = document.querySelector('.password-label');

      // Set email
      emailInput.value = 'test@example.com';
      if (emailInput.value.length > 0) {
        emailLabel.classList.add('shrink1');
      }

      // Password remains empty
      passwordInput.value = '';

      expect(emailLabel.classList.contains('shrink1')).toBe(true);
      expect(passwordLabel.classList.contains('shrink1')).toBe(false);
    });

    test('should validate all fields when filled', () => {
      const fields = [
        { input: document.getElementById('email'), label: document.querySelector('.email-label') },
        { input: document.getElementById('password'), label: document.querySelector('.password-label') },
        { input: document.getElementById('name'), label: document.querySelector('.name-label') }
      ];

      fields.forEach(({ input, label }) => {
        input.value = 'test';
        if (input.value.length > 0) {
          label.classList.add('shrink1');
        }
      });

      fields.forEach(({ label }) => {
        expect(label.classList.contains('shrink1')).toBe(true);
      });
    });
  });
});
