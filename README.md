# PHP Mini Framework

A lightweight PHP framework built from scratch for educational purposes, inspired by Laravel's architecture and patterns.

> This is not a production-ready framework, but a learning project to understand modern PHP application development.

## Features

### Core Framework
- **MVC Architecture**: Organized with Models, Views, and Controllers
- **Routing System**: Flexible routing with support for GET, POST, PUT, DELETE methods and route parameters
- **Dependency Injection Container**: Automatic resolution of class dependencies
- **Middleware System**: Request/response pipeline with global and route-specific middleware
- **Template Engine**: Template rendering with layout support and data injection

### Security Features
- **Authentication System**: Complete user registration, login, and logout functionality
- **Session Management**: Secure session handling with middleware support
- **CSRF Protection**: Token generation and validation for form submissions
- **Validation Framework**: Extensible validation system with various built-in rules
- **Input Sanitization**: Proper cleaning and validation of user inputs

### Data Management
- **Database Abstraction**: Simple database interaction with prepared statements
- **Transaction Management**: CRUD operations for financial transactions
- **File Upload System**: Secure file uploads with validation and storage management
- **Receipt Management**: Attach, view, and manage receipts for transactions

### User Experience
- **Flash Messages**: Temporary session-based notifications
- **Error Handling**: Custom error pages and exception handling
- **Form Validation**: Client and server-side validation with error reporting

## Project Structure

```
├── public/                 # Public-facing files
│   ├── index.php           # Application entry point
│   ├── about.php           # About page
│   └── assets/             # CSS, JS, and other assets
├── src/                    # Source code
│   ├── App/                # Application-specific code
│   │   ├── Config/         # Configuration files and routes
│   │   ├── Controllers/    # Controllers for request handling
│   │   ├── Exceptions/     # Custom exception classes
│   │   ├── Middleware/     # Request/response middleware
│   │   ├── Services/       # Business logic services
│   │   └── views/          # View templates
│   └── Framework/          # Core framework classes
│       ├── Contracts/      # Interfaces
│       ├── Exceptions/     # Framework exceptions
│       ├── Rules/          # Validation rules
│       ├── App.php         # Main application class
│       ├── Router.php      # Routing system
│       ├── Container.php   # DI container
│       ├── Database.php    # Database connection and queries
│       ├── Validator.php   # Validation system
│       └── TemplateEngine.php # View rendering
├── storage/                # File storage
│   └── uploads/            # User uploaded files
│       └── receipts/       # Receipt file storage
└── cli.php                 # Command-line interface script
```

## Getting Started

1. Clone this repository
2. Copy `.env.example` to `.env` and configure your database settings
3. Run `composer install`
4. Import `database.sql` to your MySQL database
5. Configure your web server to point to the `public` directory
6. Visit the site in your browser

## Application Features

### Authentication
- User registration with email, password, age, country, and social media URL
- Login with email and password
- Logout functionality
- Protected routes for authenticated users

### Transaction Management
- Create new financial transactions with description, amount, and date
- View list of transactions
- Edit existing transactions
- Delete transactions
- Filter and search transactions

### Receipt Management
- Upload receipts (images/files) for transactions
- View uploaded receipts
- Delete receipts
- Secure file storage

## Learning Outcomes

This framework was built to understand:

- Modern PHP practices (strict typing, namespacing)
- Dependency injection principles
- Routing and middleware concepts
- MVC pattern implementation
- Security best practices in web applications
- File handling and validation
- Database interaction with PDO

## Credits

This project is an implementation of Luis Ramirez Jr's PHP course on Udemy.com