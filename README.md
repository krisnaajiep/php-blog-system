# Blog System with User Authentication and Management

This is a PHP-based Blog System built with the MVC architecture and MySQL for data storage. The system allows users to create accounts, authenticate, manage their profiles, and post blog content. Admin users have additional control over user management. Key features include account activation, password recovery, and a user-friendly post management system.

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

## Technologies Used

- PHP (for backend development)
- MySQL (for database management)
- MVC Architecture (Model-View-Controller)
- HTML/CSS (for frontend design)
- JavaScript (for client-side interactions)
- Bootstrap 5 (for CSS framework)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/blog-system.git
   ```
2. Navigate to the project directory:
   ```bash
   cd blog-system
   ```
3. Configure the database settings in `config/config.php`.
4. Move the project files to the XAMPP `htdocs` directory (usually located in `C:\xampp\htdocs` on Windows or `/Applications/XAMPP/htdocs` on macOS):
   ```bash
   mv blog-system /path-to-xampp/htdocs/
   ```
5. Start XAMPP Control Panel and launch the **Apache** and **MySQL** services.
6. Access the application at `http://localhost/php-blog-system/public` (adjust the URL if your project is in a subfolder within `htdocs`).

## Contributing

Contributions are welcome! If you'd like to contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Create a new Pull Request describing your changes.

## Contact

If you have any questions or suggestions, feel free to reach out:

- Email: krisnaajiep@gmail.com
- GitHub: krisnaajie(https://github.com/krisnaajirp)
