document.addEventListener('DOMContentLoaded', () => {
    console.log("Agil Shop script loaded.");
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartTotalContainer = document.getElementById('cart-total-container'); 
    const checkoutBtn = document.getElementById('checkout-btn');
    
    // --- Cart Logic ---
    const SHIPPING_COST = 4.95; // Define fixed shipping cost
    
    // Load cart from localStorage or initialize an empty array
    let cart = JSON.parse(localStorage.getItem('agilShopCart')) || [];
    
    // Function to save cart to localStorage
    const saveCart = () => {
        localStorage.setItem('agilShopCart', JSON.stringify(cart));
    };
    
    // Function to update cart count badge
    const updateCartBadge = () => {
        const cartCountElements = document.querySelectorAll('.cart-badge');
        if (!cartCountElements) return;
        
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        
        cartCountElements.forEach(element => {
            element.textContent = totalItems;
        });
    };
    
    // Initialize cart badge when page loads
    updateCartBadge();
    
    // Function to add an item to the cart
    const addItemToCart = (id, name, price, image = null) => {
        // --- Input Validation ---
        const validId = id;
        const validName = name && name.trim() !== '' ? name : null;
        const validPrice = parseFloat(price);
        
        if (!validId || !validName || isNaN(validPrice) || validPrice < 0) {
            console.error('Attempted to add invalid item to cart:', { id, name, price });
            alert('Fehler: Ungültiges Produkt konnte nicht zum Warenkorb hinzugefügt werden.');
            return;
        }
        
        // Check if item already exists
        const existingItemIndex = cart.findIndex(item => item.id === validId);
        
        if (existingItemIndex > -1) {
            // Increase quantity
            cart[existingItemIndex].quantity += 1;
        } else {
            // Add new item with validated data
            cart.push({ 
                id: validId, 
                name: validName, 
                price: validPrice, 
                quantity: 1,
                image: image 
            });
        }
        
        saveCart();
        updateCartBadge();
        alert(`${validName} zum Warenkorb hinzugefügt!`);
        updateCartDisplay();
    };
    
    // Function to update the cart display on cart.html
    const updateCartDisplay = () => {
        if (!cartItemsContainer || !cartTotalContainer || !checkoutBtn) return; // Only run on cart page
        
        cartItemsContainer.innerHTML = ''; // Clear current display
        let subtotal = 0;
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p>Ihr Warenkorb ist derzeit leer.</p>';
            cartTotalContainer.innerHTML = '';
            checkoutBtn.style.display = 'none';
        } else {
            cart.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('cart-item');
                
                // Add image if available
                const imageHtml = item.image ? 
                    `<img src="${item.image}" alt="${item.name}" class="cart-item-image" width="50">` : 
                    '';
                
                itemElement.innerHTML = `
                    ${imageHtml}
                    <span>${item.name} (x${item.quantity})</span>
                    <span>€${(item.price * item.quantity).toFixed(2)}</span>
                    <button class="remove-item-btn btn btn-remove" data-id="${item.id}">Entfernen</button>
                `;
                cartItemsContainer.appendChild(itemElement);
                subtotal += item.price * item.quantity;
            });
            
            const total = subtotal + SHIPPING_COST;
            
            // Update the total container with subtotal, shipping, and total
            cartTotalContainer.innerHTML = `
                <p>Zwischensumme: €${subtotal.toFixed(2)}</p>
                <p>Versandkosten: €${SHIPPING_COST.toFixed(2)}</p>
                <p class="total-bold">Gesamt: €${total.toFixed(2)}</p>
            `;
            
            checkoutBtn.style.display = 'inline-block';
            addRemoveButtonListeners();
        }
    };
    
    // Function to remove an item from the cart
    const removeItemFromCart = (idToRemove) => {
        cart = cart.filter(item => String(item.id) !== String(idToRemove));
        saveCart();
        updateCartBadge();
        updateCartDisplay();
    };
    
    // Function to add listeners to remove buttons
    const addRemoveButtonListeners = () => {
        const removeButtons = cartItemsContainer.querySelectorAll('.remove-item-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const itemId = event.target.getAttribute('data-id');
                removeItemFromCart(itemId);
            });
        });
    };
    
    // --- Add to Cart button listeners (fix for directly clicking Add to Cart) ---
    function setupAddToCartButtons() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        
        addToCartButtons.forEach(button => {
            // Clear any existing event listeners to prevent duplicates
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            newButton.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent navigating when inside an <a> tag
                event.stopPropagation(); // Stop event bubbling
                
                const target = event.currentTarget; // Use currentTarget to get the button element
                const id = target.getAttribute('data-id');
                const name = target.getAttribute('data-name');
                const price = target.getAttribute('data-price');
                const image = target.getAttribute('data-image') || null;
                
                console.log("Adding to cart:", { id, name, price, image }); // Debug log
                
                addItemToCart(id, name, price, image);
            });
        });
    }
    
    // Apply initial button setup
    setupAddToCartButtons();
    
    // Initial cart display update if on cart page
    if (cartItemsContainer) {
        updateCartDisplay();
    }
    
    // --- Load Products from Database ---
    const loadProducts = async (category = null, container = null) => {
        if (!container) {
            console.error("No container provided to loadProducts function");
            return;
        }
        
        // Show the loading indicator if it exists
        const loadingIndicator = document.querySelector('.loading-container');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }
        
        try {
            console.log(`Loading products for category: ${category || 'all'} into`, container.id);
            
            // Use relative paths for API URLs to match the current server port
            const apiUrl = category ? 
                `/api/get_products.php?category=${category}` :
                '/api/get_products.php';
            
            console.log("Fetching from:", apiUrl);
                
            // Fetch products from API
            const response = await fetch(apiUrl);
            
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            
            const products = await response.json();
            console.log(`Received ${products.length} products:`, products);
            
            // Clear the container
            container.innerHTML = '';
            
            if (products.length === 0) {
                container.innerHTML = '<p>Keine Produkte in dieser Kategorie gefunden.</p>';
                return;
            }
            
            // Display products
            products.forEach(product => {
                const productItem = document.createElement('div');
                productItem.classList.add('product-item', 'fade-in');
                
                productItem.innerHTML = `
                    <a href="/pages/product-detail.html?id=${product.id}" class="product-link">
                        <img src="${product.image_url}" alt="${product.name}">
                        <div class="product-info">
                            <h3>${product.name}</h3>
                            <p>${product.description}</p>
                            <div class="product-meta">
                                <p class="price">€${parseFloat(product.price).toFixed(2)}</p>
                                <button class="btn add-to-cart-btn" 
                                    data-id="${product.id}" 
                                    data-name="${product.name}" 
                                    data-price="${product.price}"
                                    data-image="${product.image_url}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                `;
                
                container.appendChild(productItem);
            });
            
            // Hide loading indicator
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            
            // Re-attach click events to new buttons
            setupAddToCartButtons();
            
        } catch (error) {
            console.error("Error loading products:", error);
            container.innerHTML = `
                <div class="error-message">
                    <p>Entschuldigung, die Produkte konnten nicht geladen werden.</p>
                    <p>Fehler: ${error.message}</p>
                </div>
            `;
            
            // Hide loading indicator on error also
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
        }
    };
    
    // --- Product Detail Page Logic ---
    const productDetailContainer = document.getElementById('product-detail');
    if (productDetailContainer && window.location.pathname.includes('product-detail.html')) {
        const params = new URLSearchParams(window.location.search);
        const productId = params.get('id');
        
        const loadingState = document.getElementById('loading-state');
        const productWrapper = document.getElementById('product-detail-wrapper');
        const errorState = document.getElementById('error-state');
        const categoryLink = document.getElementById('category-link');
        const productBreadcrumb = document.getElementById('product-breadcrumb');
        
        if (productId) {
            // Show loading state
            loadingState.style.display = 'block';
            productWrapper.style.display = 'none';
            errorState.style.display = 'none';
            
            // Fetch product details from API using relative path
            fetch(`/api/get_products.php?id=${productId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(product => {
                    // Hide loading, show product
                    loadingState.style.display = 'none';
                    productWrapper.style.display = 'block';
                    errorState.style.display = 'none';
                    
                    // Update page title and breadcrumb
                    document.title = `${product.name} - Agil Shop`;
                    productBreadcrumb.textContent = product.name;
                    
                    // Update category link in breadcrumb
                    const categoryPages = {
                        'photos': { url: 'photos.html', name: 'Taubenfotos' },
                        'merch': { url: 'merch.html', name: 'Tauben Merch' },
                        'courses': { url: 'courses.html', name: 'Kurse' }
                    };
                    
                    if (categoryPages[product.category]) {
                        categoryLink.href = categoryPages[product.category].url;
                        categoryLink.textContent = categoryPages[product.category].name;
                    }
                    
                    // Update product detail container with enhanced layout
                    productDetailContainer.innerHTML = `
                        <div class="product-detail-image">
                            <img src="${product.image_url}" alt="${product.name}">
                        </div>
                        <div class="product-detail-info">
                            <h1 class="product-title">${product.name}</h1>
                            <div class="product-price">
                                €${parseFloat(product.price).toFixed(2)}
                                <span class="price-badge">Verfügbar</span>
                            </div>
                            <div class="product-description">
                                ${product.description}
                            </div>
                            <div class="product-meta">
                                <div class="meta-item">
                                    <i class="fas fa-tag"></i>
                                    <span>Kategorie: ${categoryPages[product.category] ? categoryPages[product.category].name : product.category}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Sichere Zahlung</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Schneller Versand</span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-undo"></i>
                                    <span>30 Tage Rückgabe</span>
                                </div>
                            </div>
                            <div class="product-actions">
                                <button class="btn add-to-cart-btn" 
                                    data-id="${product.id}" 
                                    data-name="${product.name}" 
                                    data-price="${product.price}"
                                    data-image="${product.image_url}">
                                    <i class="fas fa-cart-plus"></i>
                                    In den Warenkorb
                                </button>
                            </div>
                        </div>
                    `;
                    
                    // Setup Add to Cart button
                    setupAddToCartButtons();
                })
                .catch(error => {
                    console.error("Error loading product details:", error);
                    
                    // Hide loading, show error
                    loadingState.style.display = 'none';
                    productWrapper.style.display = 'none';
                    errorState.style.display = 'block';
                });
        } else {
            // No product ID provided
            loadingState.style.display = 'none';
            productWrapper.style.display = 'none';
            errorState.style.display = 'block';
        }
    }
    
    // --- Execute product loading for each page type ---
    // We need to make sure we directly call loadProducts for each container
    
    // Photos page
    const photosContainer = document.getElementById('photos-container');
    if (photosContainer) {
        console.log("Found photos container, loading products");
        loadProducts('photos', photosContainer);
    }
    
    // Merch page
    const merchContainer = document.getElementById('merch-container');
    if (merchContainer) {
        console.log("Found merch container, loading products");
        loadProducts('merch', merchContainer);
    }
    
    // Courses page
    const coursesContainer = document.getElementById('courses-container');
    if (coursesContainer) {
        console.log("Found courses container, loading products");
        loadProducts('courses', coursesContainer);
    }
    
    // Featured products on homepage
    const featuredProductsContainer = document.querySelector('.featured-products .product-grid');
    if (featuredProductsContainer) {
        if (window.location.pathname.endsWith('index.html') || window.location.pathname === '/' || window.location.pathname === '') {
            console.log("Found featured products container on homepage, loading products");
            loadProducts(null, featuredProductsContainer);
        }
    }
    
    // --- Checkout Form ---
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission
            
            if (cart.length === 0) {
                alert('Ihr Warenkorb ist leer. Bitte fügen Sie Produkte hinzu, bevor Sie bestellen.');
                return;
            }
            
            // Collect form data
            const formData = {
                customer: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                    address: document.getElementById('address').value
                },
                items: cart,
                shipping_cost: SHIPPING_COST
            };
            
            try {
                // Submit order to API using relative path
                const response = await fetch('/api/place_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                });
                
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Fehler beim Absenden der Bestellung');
                }
                
                const data = await response.json();
                
                // Clear cart after successful order
                cart = [];
                saveCart();
                updateCartBadge();
                
                // Show confirmation message with transaction ID
                alert(`Bestellung erfolgreich aufgegeben! Ihre Transaktions-ID lautet: ${data.transaction_id}`);
                
                // Store transaction ID in localStorage for order tracking
                localStorage.setItem('lastTransactionId', data.transaction_id);
                
                // Redirect to a thank you page or show order confirmation
                window.location.href = 'bestellung/order-confirmation.html';
                
            } catch (error) {
                console.error("Error placing order:", error);
                alert(`Bestellvorgang fehlgeschlagen: ${error.message}`);
            }
        });
    }
    
    // --- Order Tracking ---
    const orderTrackingForm = document.getElementById('order-tracking-form');
    if (orderTrackingForm) {
        orderTrackingForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            const transactionId = document.getElementById('transaction-id').value.trim();
            if (!transactionId) {
                alert('Bitte geben Sie eine gültige Transaktions-ID ein.');
                return;
            }
            
            // Get order details using relative path
            try {
                const response = await fetch(`/api/check_order.php?transaction_id=${transactionId}`);
                
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Bestellung nicht gefunden');
                }
                
                const data = await response.json();
                const order = data.order;
                
                // Display order details
                const orderDetailsContainer = document.getElementById('order-details');
                
                orderDetailsContainer.innerHTML = `
                    <div class="order-details-container">
                        <h3>Bestelldetails</h3>
                        <p><strong>Transaktions-ID:</strong> ${order.transaction_id}</p>
                        <p><strong>Name:</strong> ${order.customer_name}</p>
                        <p><strong>Gesamtbetrag:</strong> €${parseFloat(order.total_amount).toFixed(2)}</p>
                        <p><strong>Status:</strong> ${order.status}</p>
                        <p><strong>Datum:</strong> ${new Date(order.created_at).toLocaleDateString('de-DE')}</p>
                        
                        <h4>Bestellte Artikel</h4>
                        <div class="ordered-items">
                            ${order.items.map(item => `
                                <div class="ordered-item">
                                    ${item.image_url ? `<img src="${item.image_url}" alt="${item.name}" width="50">` : ''}
                                    <span>${item.name} (x${item.quantity})</span>
                                    <span>€${parseFloat(item.price).toFixed(2)}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
                
            } catch (error) {
                console.error("Error checking order:", error);
                document.getElementById('order-details').innerHTML = `
                    <div class="error-message">
                        <p>${error.message}</p>
                    </div>
                `;
            }
        });
        
        // Try to pre-fill transaction ID from localStorage
        const lastTransactionId = localStorage.getItem('lastTransactionId');
        if (lastTransactionId) {
            document.getElementById('transaction-id').value = lastTransactionId;
        }
    }
});
