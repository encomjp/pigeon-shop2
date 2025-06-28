// Simple JS to show credit card field based on payment type
function toggleCardField() {
  var payment = document.getElementById('payment-select');
  var card = document.getElementById('credit-card');
  if (!payment || !card) return;
  card.style.display = payment.value === 'kreditkarte' ? 'block' : 'none';
}

// Format credit card number with spaces
function formatCreditCard(input) {
  var value = input.value.replace(/\D/g, ''); // Remove non-digits
  var formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1 '); // Add space every 4 digits
  if (formattedValue.length <= 19) { // Max length with spaces: 16 digits + 3 spaces
    input.value = formattedValue;
  }
}

document.addEventListener('DOMContentLoaded', function() {
  var payment = document.getElementById('payment-select');
  if (payment) {
    payment.addEventListener('change', toggleCardField);
    // Show credit card field on page load if needed
    toggleCardField();
  }

  // Add credit card formatting
  var cardInput = document.getElementById('card_number');
  if (cardInput) {
    // Format existing value on page load
    if (cardInput.value) {
      formatCreditCard(cardInput);
    }
    
    cardInput.addEventListener('input', function() {
      formatCreditCard(this);
    });
    cardInput.addEventListener('keydown', function(e) {
      // Allow backspace, delete, tab, escape, enter
      if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
          // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
          (e.keyCode === 65 && e.ctrlKey === true) ||
          (e.keyCode === 67 && e.ctrlKey === true) ||
          (e.keyCode === 86 && e.ctrlKey === true) ||
          (e.keyCode === 88 && e.ctrlKey === true)) {
        return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  }

  var form = document.querySelector('form[data-autosave="true"]');
  if (form) {
    var saved = localStorage.getItem('checkout-form');
    if (saved) {
      try {
        var data = JSON.parse(saved);
        for (var k in data) {
          if (form.elements[k]) form.elements[k].value = data[k];
        }
        toggleCardField();
        // Format card number if it was restored from localStorage
        if (cardInput && cardInput.value) {
          formatCreditCard(cardInput);
        }
      } catch(e) {}
    }
    form.addEventListener('input', function() {
      var data = {};
      Array.from(form.elements).forEach(function(el){
        if (el.name) data[el.name] = el.value;
      });
      localStorage.setItem('checkout-form', JSON.stringify(data));
    });
    form.addEventListener('submit', function(){
      localStorage.removeItem('checkout-form');
    });
  }
});
