// Simple JS to show credit card field based on payment type
function toggleCardField() {
  var payment = document.getElementById('payment-select');
  var card = document.getElementById('credit-card');
  if (!payment || !card) return;
  card.style.display = payment.value === 'kreditkarte' ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function() {
  var payment = document.getElementById('payment-select');
  if (payment) {
    payment.addEventListener('change', toggleCardField);
    toggleCardField();
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
