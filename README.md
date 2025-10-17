# PHP MVC Framework with DataTables Server-Side Processing

A lightweight, modern PHP MVC (Model-View-Controller) framework with integrated DataTables server-side processing, Bootstrap 4 UI, and comprehensive user management system.

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-4.5.2-purple)](https://getbootstrap.com/)
[![DataTables](https://img.shields.io/badge/DataTables-1.10.24-orange)](https://datatables.net/)

## 🚀 Features

- **MVC Architecture**: Clean separation of concerns with Model-View-Controller pattern
- **Server-Side DataTables**: Efficient handling of large datasets with AJAX pagination, sorting, and filtering
- **User Authentication**: Complete user management system with role-based access control
- **Bootstrap 4**: Modern, responsive UI components
- **Security Features**: 
  - HTTPS detection (proxy/load balancer compatible)
  - SQL injection protection
  - CSRF token validation
  - Password hashing
- **Database Integration**: PDO-based database abstraction layer
- **Export Functionality**: Export data to CSV, Excel, PDF, and Print
- **Real-time Updates**: Auto-refresh DataTables with AJAX
- **Session Management**: Secure user session handling

## 📋 Requirements

- PHP >= 7.4 (PHP 8.0+ recommended)
- MySQL >= 5.7 or MariaDB >= 10.2
- Apache/Nginx web server with mod_rewrite enabled
- Composer (optional, for dependency management)

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/elightsys/PHP-MVC-03.git
cd PHP-MVC-03
```

### 2. Configure Database

Import the database schema:

```bash
mysql -u your_username -p your_database_name < mysql.sql
```

### 3. Configure Application

Copy the example configuration file and update it with your settings:

```bash
cp app/config/config.php.example app/config/config.php
```

Edit `app/config/config.php` and update the following:

```php
// Database credentials
define('__DB_HOST__', 'localhost');
define('__DB_USER__', 'your_db_username');
define('__DB_PASS__', 'your_db_password');
define('__DB_NAME__', 'your_db_name');

// Generate a unique security key
define('__UNIQID__', md5(uniqid(rand(), true)));
```

### 4. Set Permissions

```bash
chmod -R 755 public/
chmod -R 777 storage/logs/ storage/cache/
```

### 5. Configure Web Server

#### Apache (.htaccess)

The `.htaccess` file is already included. Make sure `mod_rewrite` is enabled:

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

#### Nginx

Add this to your server block:

```nginx
location / {
	try_files $uri $uri/ /public/index.php?$query_string;
}

location ~ \.php$ {
	include snippets/fastcgi-php.conf;
	fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
}
```

### 6. Access Your Application

Navigate to: `http://your-domain.com/public/`

Default login credentials (change immediately after first login):
- Email: `admin@example.com`
- Password: `admin123`

## 📁 Project Structure

```
PHP-MVC-03/
├── app/
│   ├── config/
│   │   ├── config.php.example    # Configuration template
│   │   └── config.php            # Your config (git-ignored)
│   ├── controllers/              # Application controllers
│   │   ├── Pages.php
│   │   ├── Users.php
│   │   └── Admin.php
│   ├── models/                   # Data models
│   │   ├── SspModel.php
│   │   └── AdminModel.php
│   ├── views/                    # View templates
│   │   ├── pages/
│   │   ├── admin/
│   │   └── _inc/
│   ├── libraries/                # Core libraries
│   │   ├── Core.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   └── Ssp.php
│   ├── helpers/                  # Helper functions
│   └── autoload.php             # Autoloader
├── public/                       # Public web directory
│   ├── index.php                # Front controller
│   ├── assets/                  # CSS, JS, images
│   └── uploads/                 # User uploads
├── mysql.sql                    # Database schema
├── .gitignore
├── .htaccess
├── LICENSE
└── README.md
```

## 🎯 Usage

### Basic Routing

Routes are automatically mapped to controllers:

```
http://your-domain.com/public/Pages/Users
							   ↓      ↓
						  Controller  Method
```

### Creating a New Controller

```php
<?php
class YourController extends Controller {
    
	public function index() {
		$data = [
			'title' => 'Your Page Title'
		];
		$this->view('your-view', $data);
	}
}
```

### DataTables Server-Side Processing

The framework includes a powerful DataTables SSP (Server-Side Processing) implementation:

```php
public function SspUsersDT() {
	if (isset($_POST['draw'])) {
		exit(self::$sspModel->sspUserDT($_POST));
	}
}
```

### Database Queries

```php
$this->db->query('SELECT * FROM users WHERE active = :active');
$this->db->bind(':active', 1);
$results = $this->db->resultSet();
```

## 🔐 Security Features

### HTTPS Detection

The framework automatically detects HTTPS connections, even behind proxies and load balancers:

```php
// Checks multiple sources for HTTPS
- $_SERVER['HTTPS']
- $_SERVER['HTTP_X_FORWARDED_PROTO']
- $_SERVER['HTTP_X_FORWARDED_SSL']
- $_SERVER['SERVER_PORT']
```

### SQL Injection Protection

All database queries use PDO prepared statements:

```php
$this->db->query('SELECT * FROM users WHERE email = :email');
$this->db->bind(':email', $email);
```

### CSRF Protection

Forms include CSRF tokens:

```php
$timestamp = time();
$token = md5('unique_salt' . $timestamp);
```

## 📊 DataTables Features

- **Server-Side Processing**: Handle millions of records efficiently
- **AJAX Pagination**: Smooth, fast pagination without page reloads
- **Search & Filter**: Real-time search across all columns
- **Sorting**: Multi-column sorting
- **Export Options**: CSV, Excel, PDF, Print
- **Responsive Design**: Mobile-friendly tables
- **Auto-refresh**: Configurable auto-refresh interval

## 🤝 Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [DataTables](https://datatables.net/) - Table plugin for jQuery
- [Bootstrap](https://getbootstrap.com/) - CSS framework
- [Font Awesome](https://fontawesome.com/) - Icon library
- [jQuery](https://jquery.com/) - JavaScript library

## 📧 Contact

- GitHub: [@elightsys](https://github.com/elightsys)
- Project Link: [https://github.com/elightsys/PHP-MVC-03](https://github.com/elightsys/PHP-MVC-03)

## 🐛 Known Issues

Please check the [Issues](https://github.com/elightsys/PHP-MVC-03/issues) page for known bugs and feature requests.

## 📚 Documentation

For more detailed documentation, please visit the [Wiki](https://github.com/elightsys/PHP-MVC-03/wiki).

---

**Note**: This is a learning/demonstration project. For production use, consider additional security measures, comprehensive testing, and regular updates.