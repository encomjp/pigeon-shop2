// JavaScript für Pigeon Shop - Hauptfunktionalität

// Zeigt/versteckt Kreditkartenfelder basierend auf der gewählten Zahlungsart
function toggleCardField() {
  var payment = document.getElementById('payment-select');
  var card = document.getElementById('credit-card');
  if (!payment || !card) return;
  card.style.display = payment.value === 'kreditkarte' ? 'block' : 'none';
}

// Formatiert die Kreditkartennummer mit Leerzeichen (alle 4 Ziffern)
function formatCreditCard(input) {
  var value = input.value.replace(/\D/g, ''); // Entfernt alle Nicht-Ziffern
  var formattedValue = value.replace(/(\d{4})(?=\d)/g, '$1 '); // Fügt Leerzeichen alle 4 Ziffern hinzu
  if (formattedValue.length <= 19) { // Maximale Länge mit Leerzeichen: 16 Ziffern + 3 Leerzeichen
    input.value = formattedValue;
  }
}

// Event-Listener beim Laden der Seite
document.addEventListener('DOMContentLoaded', function() {
  var payment = document.getElementById('payment-select');
  if (payment) {
    payment.addEventListener('change', toggleCardField);
    // Zeigt Kreditkartenfeld beim Seitenladen falls nötig
    toggleCardField();
  }

  // Kreditkarten-Formatierung hinzufügen
  var cardInput = document.getElementById('card_number');
  if (cardInput) {
    // Formatiert bestehenden Wert beim Seitenladen
    if (cardInput.value) {
      formatCreditCard(cardInput);
    }
    
    // Formatiert bei Eingabe
    cardInput.addEventListener('input', function() {
      formatCreditCard(this);
    });
    // Erlaubt nur Zahlen und bestimmte Tasten
    cardInput.addEventListener('keydown', function(e) {
      // Erlaubt Backspace, Delete, Tab, Escape, Enter
      if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
          // Erlaubt Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
          (e.keyCode === 65 && e.ctrlKey === true) ||
          (e.keyCode === 67 && e.ctrlKey === true) ||
          (e.keyCode === 86 && e.ctrlKey === true) ||
          (e.keyCode === 88 && e.ctrlKey === true)) {
        return;
      }
      // Stellt sicher, dass nur Zahlen eingegeben werden
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });
  }

  // Auto-Speichern für Formulare mit data-autosave="true"
  var form = document.querySelector('form[data-autosave="true"]');
  if (form) {
    // Lädt gespeicherte Formulardaten aus localStorage
    var saved = localStorage.getItem('checkout-form');
    if (saved) {
      try {
        var data = JSON.parse(saved);
        for (var k in data) {
          if (form.elements[k]) form.elements[k].value = data[k];
        }
        toggleCardField();
        // Formatiert Kartennummer falls aus localStorage wiederhergestellt
        if (cardInput && cardInput.value) {
          formatCreditCard(cardInput);
        }
      } catch(e) {}
    }
    // Speichert Formulardaten bei jeder Eingabe
    form.addEventListener('input', function() {
      var data = {};
      Array.from(form.elements).forEach(function(el){
        if (el.name) data[el.name] = el.value;
      });
      localStorage.setItem('checkout-form', JSON.stringify(data));
    });
    // Löscht gespeicherte Daten beim Absenden
    form.addEventListener('submit', function(){
      localStorage.removeItem('checkout-form');
    });
  }
});
