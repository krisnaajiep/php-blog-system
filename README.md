# PHP Blog System

PHP-based Blogging Platform Web Application built with PHP and MySQL. The system allows users to create accounts, authenticate, manage their profiles, and post blog content. Admin have additional control over user management. Key features include account activation, password recovery, and a user-friendly post management system.

## Screenshoots

### Main Page

![Simple-Blog-03-06-2025_05_31_PM](https://github.com/user-attachments/assets/33eeb68d-b38d-4c6a-95b3-27a8801e357a)

### Login Page

![Simple-Blog-03-08-2025_02_44_PM](https://github.com/user-attachments/assets/025e0582-ade8-4715-9fb7-ea5ce4fd40a0)

### Dashboard Page

![Simple-Blog-Dashboard-03-06-2025_05_42_PM](https://github.com/user-attachments/assets/0ab3c1ac-34cd-48b0-9bc0-18e5e60f24d0)

## Features

- **User Authentication**: Secure login and registration with password hashing.
- **Account Activation**: Email-based account verification.
- **Password Recovery**: Reset forgotten passwords via email.
- **User Management**: Admin can manage user accounts; users can manage their own profiles.
- **Blog Post Management**: Create, edit, and delete blog posts.
- **Categories**: Organize posts with categories.
- **Search**: Search posts by keywords and categories.
- **Pagination**: Navigate through posts.
- **User Roles**: Different roles with specific permissions.

## Technologies

- PHP (for backend development)
- MySQL (for database management)
- HTML/CSS (for frontend design)
- JavaScript (for client-side interactions)
- Bootstrap 5 (for CSS framework)

## Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/krisnaajiep/php-blog-system.git
   ```

2. Navigate to the project directory:

   ```bash
   cd php-blog-system
   ```

3. Move the project files to the XAMPP `htdocs` directory (usually located in `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS):

   ```bash
   mv php-blog-system /path-to-xampp/htdocs/
   ```

4. Create new database

   ```bash
   mysql -u root -p -e "CREATE DATABASE simple_project_blog_system;"
   ```

5. Import `simple_project_blog_system.sql` file

   ```bash
   mysql -u root -p simple_project_blog_system < config/simple_project_blog_system.sql
   ```

6. Configure the database, base url, and base directory settings in `config/config.php`.

7. Start XAMPP Control Panel and launch the **Apache** and **MySQL** services.

8. Access the application at `http://localhost/php-blog-system` (adjust the URL if your project is in a subfolder within `htdocs`).
