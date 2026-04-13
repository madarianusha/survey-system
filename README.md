# Anonymous Survey System

## Project Description
This project is an Anonymous Survey System developed using Laravel. It allows administrators to upload survey questions through a CSV file and automatically generate web-based questionnaires. Each survey is assigned a unique URL that users can access without logging in. Users can submit responses anonymously, and administrators can manage surveys, view results, and download responses.

---

## Features

### Admin
- Secure login system
- Upload CSV file with survey questions
- Generate dynamic surveys
- Unique URL for each survey
- Activate / Deactivate survey links
- View submitted responses
- Download results as CSV

### Users
- Access surveys via unique URL
- Submit responses anonymously
- No login required

---

##  Technologies Used
- PHP (Laravel Framework)
- MySQL
- Blade Templates
- HTML/CSS

---

## Installation Guide

1. Download the project from GitHub as a ZIP file and extract it.

2. Open the extracted project folder in a terminal or VS Code.

3. Install project dependencies:
   composer install
   npm install
   npm run build

4. Create environment file:
   cp .env.example .env
   php artisan key:generate

5. Configure database:
   Open the `.env` file and update:
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=survey_system
   DB_USERNAME=root
   DB_PASSWORD=

6. Run database migrations:
   php artisan migrate

7. Create admin user:
   php artisan tinker

8. Start the application:
   php artisan serve

9. Open in browser:
   http://127.0.0.1:8000
