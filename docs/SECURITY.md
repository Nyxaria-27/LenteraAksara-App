# Security Policy

## Supported Versions

Currently supported versions with security updates:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within Lentera Aksara, please send an email to [dwiwahyuramadhan27@gmail.com](mailto:dwiwahyuramadhan27@gmail.com). All security vulnerabilities will be promptly addressed.

Please include the following information in your report:

* Description of the vulnerability
* Steps to reproduce the issue
* Possible impact
* Suggested fix (if any)

**Please do not:**
* Open a public issue for security vulnerabilities
* Disclose the vulnerability publicly until it has been fixed

## Security Measures

This project implements the following security measures:

### Authentication & Authorization
- Laravel Breeze for secure authentication
- Role-based access control (Admin/User)
- Password hashing using bcrypt
- CSRF protection on all forms
- Session management with secure cookies

### Input Validation
- Form request validation
- XSS prevention through Blade escaping
- SQL injection protection via Eloquent ORM
- File upload validation and sanitization

### Data Protection
- Environment variables for sensitive data
- Database credentials not committed to repository
- API keys stored in .env file
- Secure storage of user uploads

### Best Practices
- Regular dependency updates
- Secure headers configuration
- HTTPS enforcement (in production)
- Rate limiting on API endpoints
- Input sanitization

## Disclosure Policy

* Security vulnerabilities will be fixed as soon as possible
* A new release will be created with the fix
* CVE ID will be requested for critical vulnerabilities
* Credits will be given to reporters (unless they prefer to remain anonymous)

## Security Update Process

1. Vulnerability is reported privately
2. Issue is confirmed and assessed
3. Fix is developed and tested
4. Security advisory is published
5. New version is released
6. Public disclosure after fix is available

## Contact

For security concerns, please contact:
* Email: [dwiwahyuramadhan27@gmail.com](mailto:dwiwahyuramadhan27@gmail.com)
* GitHub: [@Nyxaria-27](https://github.com/Nyxaria-27)

Thank you for helping keep Lentera Aksara secure!
