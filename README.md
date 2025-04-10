# PHP Mini Framework

A lightweight PHP framework built from scratch for educational purposes, inspired by Laravel's architecture and
patterns.

> Work in progress. Also, This is not a production-ready framework.

## Features

- **MVC Architecture**: Organized with Models, Views, and Controllers
- **Routing System**: Simple and flexible routing with GET/POST method support
- **Dependency Injection Container**: Automatic resolution of class dependencies
- **Middleware Support**: Request/response pipeline with middleware functionality
- **Template Engine**: Basic template rendering with global data support

## Project Structure

```
├── public/             # Public-facing files
│   ├── index.php       # Application entry point
│   └── assets/         # CSS, JS, and other assets
├── src/                # Source code
│   ├── App/            # Application-specific code
│   │   ├── Config/     # Configuration files
│   │   ├── Controllers/# Controllers
│   │   ├── Middleware/ # Middleware classes
│   │   └── views/      # View templates
│   └── Framework/      # Core framework classes
│       ├── Contracts/  # Interfaces
│       ├── App.php     # Main application class
│       ├── Router.php  # Routing system
│       ├── Container.php # DI container
│───────└── TemplateEngine.php # View rendering
```

## Getting Started

1. Clone this repository
2. Run `composer install`
3. Configure your web server to point to the `public` directory
4. Visit the site in your browser

## Bootstrap Process

The application is bootstrapped in `src/App/bootstrap.php`, which:

1. Loads the autoloader
2. Creates a new App instance
3. Registers routes and middleware
4. Returns the app instance ready to run

## Learning PHP

This framework was built to understand the inner workings of PHP frameworks like Laravel, focusing on:

- Modern PHP practices (strict typing, namespacing)
- Dependency injection principles
- Routing and middleware concepts
- MVC pattern implementation

## License

MIT License