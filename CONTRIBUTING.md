# Contributing to PHP MVC Framework

First off, thank you for considering contributing to this project! It's people like you that make this project such a great tool.

## Code of Conduct

This project and everyone participating in it is governed by respect and professionalism. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

* **Use a clear and descriptive title** for the issue
* **Describe the exact steps to reproduce the problem**
* **Provide specific examples** to demonstrate the steps
* **Describe the behavior you observed** and what behavior you expected to see
* **Include screenshots** if relevant
* **Include your environment details** (PHP version, database version, web server)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

* **Use a clear and descriptive title**
* **Provide a step-by-step description** of the suggested enhancement
* **Provide specific examples** to demonstrate the steps
* **Describe the current behavior** and **explain the behavior you would like to see**
* **Explain why this enhancement would be useful**

### Pull Requests

* Fill in the required template
* Follow the PHP coding standards (PSR-12)
* Include thoughtful comments in your code
* End all files with a newline
* Write meaningful commit messages

## Development Process

1. **Fork the repository** and create your branch from `main`
2. **Make your changes** following the coding standards
3. **Test your changes** thoroughly
4. **Update documentation** if needed
5. **Commit your changes** with clear commit messages
6. **Push to your fork** and submit a pull request

### Setting Up Your Development Environment

```bash
# Clone your fork
git clone https://github.com/YOUR-USERNAME/PHP-MVC-03.git
cd PHP-MVC-03

# Create a new branch
git checkout -b feature/your-feature-name

# Make your changes
# ...

# Commit your changes
git add .
git commit -m "Add your meaningful commit message"

# Push to your fork
git push origin feature/your-feature-name
```

## Coding Standards

### PHP Code Style

* Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
* Use meaningful variable and function names
* Add comments for complex logic
* Keep functions small and focused
* Use type hints where possible (PHP 7.4+)

### Example:

```php
<?php

/**
 * Get user by email address
 *
 * @param string $email User's email address
 * @return array|false User data or false if not found
 */
public function getUserByEmail(string $email)
{
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);
    
    return $this->db->single();
}
```

### JavaScript Code Style

* Use modern ES6+ syntax where appropriate
* Use meaningful variable names
* Add comments for complex logic
* Use semicolons consistently

### SQL

* Use UPPERCASE for SQL keywords
* Use prepared statements to prevent SQL injection
* Use meaningful table and column names

## Git Commit Messages

* Use the present tense ("Add feature" not "Added feature")
* Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
* Limit the first line to 72 characters or less
* Reference issues and pull requests liberally after the first line

### Examples:

```
Add user authentication feature

- Implement login/logout functionality
- Add session management
- Create user registration form

Fixes #123
```

## Testing

* Test your changes thoroughly before submitting
* Include test cases if applicable
* Verify that existing functionality still works

## Documentation

* Update the README.md if you change functionality
* Comment your code where necessary
* Update inline documentation for functions and classes

## Questions?

Feel free to open an issue with your question or contact the maintainers directly.

## Recognition

Contributors will be recognized in the project's README.md file.

---

Thank you for contributing! 🎉
