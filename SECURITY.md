# Security Policy

## Supported Versions

We release patches for security vulnerabilities. Which versions are eligible for receiving such patches depends on the CVSS v3.0 Rating:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take the security of PHP MVC Framework seriously. If you believe you have found a security vulnerability, please report it to us as described below.

### Please do the following:

**DO NOT** create a public GitHub issue for security vulnerabilities.

Instead, please report security vulnerabilities by emailing:

📧 **elightsysl@gmail.com**

### What to include in your report:

- Type of issue (e.g. SQL injection, XSS, authentication bypass, etc.)
- Full paths of source file(s) related to the manifestation of the issue
- The location of the affected source code (tag/branch/commit or direct URL)
- Any special configuration required to reproduce the issue
- Step-by-step instructions to reproduce the issue
- Proof-of-concept or exploit code (if possible)
- Impact of the issue, including how an attacker might exploit it

### What to expect:

- **Acknowledgment**: We will acknowledge receipt of your vulnerability report within 48 hours.
- **Communication**: We will send you regular updates about our progress.
- **Disclosure**: Once the vulnerability is fixed, we will publicly disclose it (giving you credit if desired).

## Security Best Practices for Users

When deploying this application in production:

1. **Configuration Security**
   - Never commit `app/config/config.php` with real credentials
   - Use strong, unique database passwords
   - Generate a new `__UNIQID__` value using `md5(uniqid(rand(), true))`

2. **File Permissions**
   - Set proper file permissions (755 for directories, 644 for files)
   - Restrict write access to sensitive directories
   - Keep `storage/logs/` and `storage/cache/` writable but not web-accessible

3. **Database Security**
   - Use separate database users with minimal privileges
   - Enable MySQL's `strict mode`
   - Regularly backup your database

4. **Web Server Configuration**
   - Use HTTPS (SSL/TLS) in production
   - Configure proper security headers
   - Disable directory listing
   - Keep PHP and MySQL up to date

5. **Application Security**
   - Change default admin credentials immediately
   - Regularly update dependencies
   - Monitor error logs for suspicious activity
   - Implement rate limiting for login attempts

6. **Session Security**
   - Use secure session cookies (`session.cookie_secure = 1`)
   - Enable HttpOnly cookies (`session.cookie_httponly = 1`)
   - Set appropriate session timeout values

## Known Security Considerations

### Current Implementation

- **Password Hashing**: Uses PHP's `password_hash()` with bcrypt
- **SQL Injection Prevention**: Uses PDO prepared statements
- **CSRF Protection**: Token-based validation in forms
- **XSS Prevention**: Output escaping in views
- **Session Management**: Secure session handling with regeneration

### Areas for Enhancement (Production)

- Implement rate limiting for authentication
- Add two-factor authentication (2FA)
- Implement security headers (CSP, HSTS, etc.)
- Add input validation library
- Implement comprehensive logging and monitoring
- Add brute force protection

## Security Updates

We will notify users of security updates through:

- GitHub Security Advisories
- Release notes
- Email (for critical vulnerabilities)

## Third-Party Dependencies

This project uses several third-party libraries:

- jQuery 3.5.1
- Bootstrap 4.5.2
- DataTables 1.10.24

Please ensure you keep these dependencies updated to their latest secure versions.

## Scope

This security policy applies to:

- The core MVC framework
- Bundled controllers, models, and views
- Database abstraction layer
- Authentication system

It does not apply to:

- Custom modifications or extensions
- Third-party plugins not included in this repository
- Server configuration (Apache/Nginx/PHP)

## Comments on This Policy

If you have suggestions on how this process could be improved, please submit a pull request or open an issue.

---

**Thank you for helping keep PHP MVC Framework and its users safe!** 🔒
