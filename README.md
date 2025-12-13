# FoodFusion

**NCC Level 5 Computing Project by _Min Khant Kyaw_**

Culinary website with user authentication, community recipe sharing, cooking tips, and resource pages for culinary and educational content.

## Features

- Authentication: Login and registration with AJAX JSON responses
- Modals: Bootstrap-powered login and registration modals
- Recipes: List, view details, and community submission form with image preview
- Tips: Share quick cooking tips (logged-in users)
- Pages: `Home`, `About Us`, `Recipe Collection`, `Community Cookbook`, `Contact Us`, `Culinary Resources`, `Educational Resources`, `Privacy`
- UI: Responsive layout using Bootstrap and custom styles

## Technology Stack

- PHP 7.4+ and MySQL
- Bootstrap, jQuery, Popper
- XAMPP or PHP built-in server

### Project Structure

- `index.php` — Home page
- `includes/header.php` / `includes/footer.php` — Shared layout, nav, modals
- `auth/login.php`, `auth/register.php`, `auth/logout.php` — Authentication endpoints
- `recipes.php`, `recipe.php` — Recipe listing and detail
- `community.php` — Community features and recipe submission form
- `submit_recipe.php`, `submit_tip.php` — Form handlers
- `assets/css/` — `bootstrap.min.css`, `style.css`
- `assets/js/` — `jquery-3.7.1.min.js`, `popper.min.js`, `bootstrap.min.js`, `main.js`
- `config/db.php` — Database connection settings
- `auth/login.php` - Login API endpoint (AJAX JSON)
- `auth/register.php` - Register API endpoint (AJAX JSON)
- `auth/logout.php` - Logout endpoint (redirects to home)

### Prerequisites

- Install XAMPP (Apache + MySQL + PHP) or have PHP and MySQL installed

### Setup

- Clone or place the repo under your web root, e.g. `htdocs/mkk_foodfusion`
- Import the SQL file:
  - XAMPP: Open phpMyAdmin, create a new database named `mkk_foodfusion`, click `Import`, choose `mkk_foodfusion.sql`, and click `Go`
- Default credentials:
  - Email: `mkk@gmail.com`
  - Password: `MKK123456`
- Start your server:
  - XAMPP: Start `Apache` and `MySQL` from the XAMPP control panel
  - Visit `http://localhost/mkk-foodfusion/`

### Authentication Endpoints

- Register (AJAX JSON)
  - URL: `http://localhost/foodfusion/auth/register.php`
  - Method: `POST`
  - Headers: `X-Requested-With: XMLHttpRequest`
  - Body fields: `first_name`, `last_name`, `email`, `password`, `confirmPassword`
  - Example:
    - `curl -X POST http://localhost/foodfusion/auth/register.php -H 'X-Requested-With: XMLHttpRequest' -d 'first_name=Jane&last_name=Doe&email=jane@example.com&password=Secret123&confirmPassword=Secret123'`
- Login (AJAX JSON)
  - URL: `http://localhost/foodfusion/auth/login.php`
  - Method: `POST`
  - Headers: `X-Requested-With: XMLHttpRequest`
  - Body fields: `email`, `password`
  - Example:
    - `curl -X POST http://localhost/foodfusion/auth/login.php -H 'X-Requested-With: XMLHttpRequest' -d 'email=jane@example.com&password=Secret123'`

### Configuration

- Paths:
  - CSS: `includes/header.php` references `assets/css/bootstrap.min.css` and `assets/css/style.css` in `includes/header.php`
  - JS: include `assets/js/jquery-3.7.1.min.js`, `assets/js/popper.min.js`, `assets/js/bootstrap.min.js`, `assets/js/main.js` in `includes/footer.php`

### Usage Notes

- Modals: Login and registration modals are triggered from the header; AJAX responses show inline success/error messages
- Community: Logged-in users can submit recipes with ingredient/instruction dynamic fields and optional image preview
- Resources: Visit `Culinary Resources` and `Educational Resources` from navigation for downloadable guides and video listings

### Development

- CSS changes in `assets/css/style.css`
- JS behavior in `assets/js/main.js` (modals, form submissions, interactivity)
- PHP pages and handlers as listed above

### Author

Min Khant Kyaw
