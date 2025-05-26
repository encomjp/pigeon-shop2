# Agil Shop 🕊️

A modern, premium e-commerce platform specializing in pigeon-related products including professional photography, exclusive merchandise, and comprehensive online courses. Built with cutting-edge web technologies and featuring a glassmorphism design aesthetic.

## Table of Contents
- [Key Features](#key-features)
- [Project Structure](#project-structure)
- [Design Philosophy](#design-philosophy)
- [Quick Start](#quick-start)
  - [MAMP Setup](#mamp-setup)
  - [Linux Production Setup](#linux-production-setup)
  - [Docker Deployment](#docker-deployment)
- [Configuration](#configuration)
  - [Database Connection](#database-connection)
  - [Environment Variables](#environment-variables)
- [Usage Guide](#usage-guide)
- [API Documentation](#api-documentation)
  - [Product Endpoints](#product-endpoints)
- [Security Features](#security-features)
- [Performance Optimizations](#performance-optimizations)
- [Testing](#testing)
  - [Manual Testing Checklist](#manual-testing-checklist)
  - [Browser Compatibility](#browser-compatibility)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)

## ✨ Key Features

### 🎨 **Modern Design**
- **Glassmorphism UI** with backdrop blur effects and gradient overlays
- **Responsive design** optimized for all devices (mobile-first approach)
- **Dark/light theme** with CSS custom properties
- **Smooth animations** and micro-interactions throughout
- **Modern typography** using Inter font family

### 🛍️ **E-commerce Functionality**
- **Dynamic product catalog** with real-time database integration
- **Advanced shopping cart** with persistent localStorage
- **Streamlined checkout** process with form validation
- **Order management** system with transaction tracking
- **Product categories**: Professional photos, branded merchandise, educational courses

### 🔧 **Technical Excellence**
- **RESTful API** architecture with PHP backend
- **MySQL database** with optimized queries and indexing
- **Modern JavaScript** (ES6+) with modular architecture
- **CSS Grid & Flexbox** for advanced layouts
- **Font Awesome** icons for consistent iconography
- **Progressive enhancement** for optimal performance

### 📱 **User Experience**
- **Intuitive navigation** with breadcrumb trails
- **Loading states** and error handling
- **Product search** and filtering capabilities
- **Real-time cart updates** with badge notifications
- **Order tracking** system with detailed status updates

## 🗂️ Project Structure

```
📁 Agil Shop/
├── 🏠 index.html                    # Modern homepage with hero section & testimonials
├── 📋 README.md                     # This comprehensive documentation
├── 🗄️ shop_database.db             # SQLite database file
│
├── 📄 pages/                        # Category & information pages
│   ├── 📸 photos.html               # Professional pigeon photography gallery
│   ├── 👕 merch.html                # Branded merchandise collection
│   ├── 🎓 courses.html              # Educational course offerings
│   ├── 🔍 product-detail.html       # Enhanced product detail page
│   ├── ⚖️ impressum.html            # Legal imprint (German compliance)
│   └── 🔒 datenschutz.html          # Privacy policy (GDPR compliant)
│
├── 🛒 bestellung/                   # Complete order management system
│   ├── 🛍️ cart.html                 # Modern shopping cart interface
│   ├── 💳 checkout.html             # Streamlined checkout process
│   ├── ✅ order-confirmation.html   # Order success confirmation
│   └── 📦 order-tracking.html       # Real-time order tracking
│
├── 🎨 css/                          # Styling & design system
│   └── 💎 style.css                # Modern CSS with custom properties & animations
│
├── ⚡ js/                           # Interactive functionality
│   └── 🚀 script.js                # Modern JavaScript with ES6+ features
│
├── 🔌 api/                          # RESTful API endpoints
│   ├── 📊 get_products.php         # Product data retrieval
│   ├── 📝 place_order.php          # Order processing & validation
│   └── 🔍 check_order.php          # Order status checking
│
└── ⚙️ config/                       # Configuration & setup
    ├── 🔗 db_connect.php           # Database connection management
    └── 🏗️ setup_db.php             # Automated database initialization
```

## 🎯 Design Philosophy

**Agil Shop** embraces modern web design principles:

- **Glassmorphism**: Semi-transparent elements with backdrop filters
- **Micro-interactions**: Subtle animations that enhance user engagement
- **Accessibility-first**: WCAG 2.1 compliant design patterns
- **Performance-optimized**: Lazy loading and efficient resource management
- **Mobile-responsive**: Progressive enhancement from mobile to desktop

## 🚀 Quick Start

### Prerequisites
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **PHP**: Version 7.4 or higher with PDO extension
- **MySQL**: Version 5.7+ or MariaDB 10.2+
- **Modern Browser**: Chrome 88+, Firefox 85+, Safari 14+

### ⚡ MAMP Setup (Recommended for Development)

1. **Install MAMP**:
   ```bash
   # Download from: https://www.mamp.info/
   # Install and configure with default settings
   ```

2. **Clone Repository**:
   ```bash
   cd /Applications/MAMP/htdocs/
   git clone <repository-url> agil-shop
   ```

3. **Database Setup**:
   - Start MAMP servers (Apache & MySQL)
   - Navigate to: `http://localhost/agil-shop/config/setup_db.php`
   - Verify installation at: `http://localhost/agil-shop/`

### 🐧 Linux Production Setup

1. **Install LAMP Stack**:
   ```bash
   # Ubuntu/Debian
   sudo apt update && sudo apt install -y apache2 mysql-server php php-mysql php-pdo
   
   # Enable required modules
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. **Configure Database**:
   ```sql
   mysql -u root -p
   CREATE DATABASE agil_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'agil_user'@'localhost' IDENTIFIED BY 'secure_password';
   GRANT ALL PRIVILEGES ON agil_shop.* TO 'agil_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. **Deploy Application**:
   ```bash  
   sudo git clone <repository-url> /var/www/html/agil-shop
   sudo chown -R www-data:www-data /var/www/html/agil-shop
   sudo chmod -R 755 /var/www/html/agil-shop
   ```

### 🐳 Docker Deployment

```yaml
# docker-compose.yml
version: '3.8'
services:
  web:
    image: php:8.1-apache
    ports:
      - "80:80"
    volumes:
      - ./:/var/www/html
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html
    depends_on:
      - database

  database:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: agil_shop
      MYSQL_USER: agil_user
      MYSQL_PASSWORD: userpassword
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

```bash
docker-compose up -d
```

## 🛠️ Configuration

### Database Connection
Edit `/config/db_connect.php`:

```php
// Production configuration
$host = 'localhost';          // Database host
$db_name = 'agil_shop';       // Database name  
$username = 'agil_user';      // Database user
$password = 'secure_password'; // Database password
$port = 3306;                 // Database port (MAMP: 8889)
```

### Environment Variables
For production, consider using environment variables:

```php
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db_name = $_ENV['DB_NAME'] ?? 'agil_shop';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
```

## 🎮 Usage Guide

### 🏠 **Homepage Experience**
- **Hero Section**: Animated GIF background with call-to-action buttons
- **Featured Products**: Dynamic grid showcasing popular items
- **Testimonials**: Customer reviews with animated cards
- **Modern Navigation**: Dropdown menus with hover effects

### 🛍️ **Shopping Flow**
1. **Browse Categories**: Photos, Merch, or Courses
2. **Product Details**: Enhanced product pages with breadcrumbs
3. **Add to Cart**: Real-time cart updates with animations
4. **Checkout**: Streamlined form with validation
5. **Track Order**: Real-time status tracking

### 📱 **Mobile Experience**
- **Touch-optimized**: Large tap targets and gesture support
- **Responsive Design**: Fluid layouts that adapt to any screen
- **Fast Loading**: Optimized images and lazy loading
- **Offline Support**: Service worker for core functionality

## 🔌 API Documentation

### Product Endpoints

#### `GET /api/get_products.php`
Retrieve product information with filtering options.

**Parameters:**
- `category` (optional): Filter by 'photos', 'merch', or 'courses'
- `id` (optional): Get specific product by ID

**Response:**
```json
{
  "id": 1,
  "name": "Majestätische Stadttaube",
  "description": "Eine beeindruckende Taube mit Blick über die Stadt.",
  "price": "15.99",
  "image_url": "https://example.com/image.jpg",
  "category": "photos",
  "stock_quantity": 50,
  "created_at": "2025-05-26T10:30:00Z"
}
```

#### `POST /api/place_order.php`
Process new orders with comprehensive validation.

**Request Body:**
```json
{
  "customer": {
    "name": "Max Mustermann",
    "email": "max@example.com",
    "address": "Musterstraße 123, 12345 Berlin"
  },
  "items": [
    {"id": 1, "quantity": 2, "price": 15.99}
  ],
  "shipping_cost": 4.95
}
```

#### `GET /api/check_order.php`
Track order status and details.

**Parameters:**
- `transaction_id`: Unique order identifier

## 🔒 Security Features

- **Input Validation**: Comprehensive server-side validation
- **SQL Injection Protection**: Prepared statements throughout
- **XSS Prevention**: Output escaping and Content Security Policy
- **CSRF Protection**: Token-based form validation
- **Rate Limiting**: API endpoint protection

## 🚀 Performance Optimizations

- **Lazy Loading**: Images load as they enter viewport
- **CSS Optimization**: Custom properties and efficient selectors
- **JavaScript Bundling**: Modular code with efficient loading
- **Database Indexing**: Optimized queries for fast responses
- **Caching Headers**: Browser caching for static assets

## 🧪 Testing

### Manual Testing Checklist
- ✅ Homepage loads with all animations
- ✅ Product categories display correctly
- ✅ Shopping cart persistence works
- ✅ Checkout process completes successfully
- ✅ Order tracking functions properly
- ✅ Mobile responsive design works
- ✅ All API endpoints respond correctly

### Browser Compatibility
- ✅ Chrome 88+ (Full support)
- ✅ Firefox 85+ (Full support) 
- ✅ Safari 14+ (Full support)
- ✅ Edge 88+ (Full support)

## 🐛 Troubleshooting

### Common Issues

**Products not loading:**
```bash
# Check database connection
php config/setup_db.php
```

**Cart not persisting:**
```javascript
// Clear localStorage and refresh
localStorage.clear();
location.reload();
```

**API errors:**
```bash
# Check PHP error logs
tail -f /var/log/apache2/error.log
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- **Design Inspiration**: Modern e-commerce platforms and glassmorphism trends
- **Icons**: Font Awesome for consistent iconography
- **Fonts**: Inter font family for modern typography
- **Images**: Placeholder images from various pigeon photography sources

---

**Built with ❤️ for pigeon enthusiasts worldwide** 🕊️