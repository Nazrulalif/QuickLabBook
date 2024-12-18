<p align="center"><a href="https://laravel.com" target="_blank"><img
            src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"
            width="400" alt="Laravel Logo"></a></p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions"><img
            src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
            src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
            src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
            src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Lab Equipment Booking System

This system allows users to book lab equipment without logging in. It includes admin management for approving/rejecting
bookings and notifying users via email.

## Features

1. User Side:
- Submit equipment booking requests.
- Receive booking status notifications via email.

2. Admin Side:
- Approve, reject, or return bookings.
- Add comments while updating booking status.
- View pending bookings in a customized dashboard widget.
- Email notifications with booking details, item quantities, and additional comments.

3. Technical Features:
- Email notifications (via Laravel Mail).
- Filament Admin Panel for managing bookings.
- File storage for uploaded files.

## System Requirements
- PHP >= 8.1
- Laravel 10
- Laragon/xampp
- Composer
- MySQL or any supported database

## Installation Steps

1. Clone the Repository
```bash
git clone https://github.com/Nazrulalif/QuickLabBook.git
cd QuickLabBook
```
2. Update Dependencies
```bash
composer update
```
3. Environment Configuration
Copy the .env.example file to .env:
```bash
cp .env.example .env
```
Database Configuration:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
Email Configuration:
```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="example@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
4. Run Migrations
Run database migrations to set up the required tables:
```bash
php artisan migrate
```
5. Storage Setup
Create a symbolic link to the storage folder for public access:
```bash
php artisan storage:link
```
6. Filament Admin Setup
configure the Filament Admin user:
```bash
php artisan make:filament-user
```
7. Serve the Application
Start the development server:
```bash
php artisan serve
```

## Admin Panel Access
```bash
http://<domain>/admin
```

## Contributing
Pull requests are welcome. For significant changes, please open an issue first to discuss what you would like to
change.

## Contact
If you have any questions, reach out at:
Email: nazrulism17@gmail.com
GitHub: https://github.com/Nazrulalif

Your Laravel application is now ready to use! 🚀
