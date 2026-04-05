# Mini Web Login + Store Project

This is a PHP and MariaDB mini web app I built to practice login systems, session security, and database-driven order workflows.

The main goal of this project was to move beyond just making the happy path work. I wanted to understand what happens when users send bad input, fake IDs, or try to access pages directly.

Through this project, I got more hands-on with:
- PHP authentication
- session handling
- prepared statements
- server-side validation
- order workflows
- debugging bugs and edge cases
- Git and GitHub project structure

---

## Features
- User registration
- Login with hashed passwords
- Session-based protected pages
- Product dashboard
- Checkout summary
- Order confirmation page
- Auto-generated order ID
- User-specific order history
- Secure logout
- Safe GitHub config setup using `.gitignore`

---

## Tech Used
- PHP
- MariaDB / MySQL
- Apache
- HTML forms
- PHP sessions
- MySQLi prepared statements
- Git + GitHub

---

## Project Files
- `index.php` → login page
- `register.php` → registration
- `dashboard.php` → product page
- `checkout.php` → order summary
- `submit_order.php` → saves order into database
- `order_history.php` → shows old user orders
- `logout.php` → destroys session
- `config.example.php` → safe sample config
- `.gitignore` → hides secrets and local test files

---

## Security Work
Some security improvements I focused on:
- prepared statements for SQL safety
- password hashing with `password_hash()`
- password checking with `password_verify()`
- session checks on protected pages
- validating GET and POST input
- blocking fake product IDs
- validating quantity before calculations
- hiding real DB credentials from GitHub

---

## Testing and Debugging
I intentionally tried to break the app in different ways to see how it handled bad input and direct route access.

### Things I tested
1. Opened protected pages without logging in
   - Got redirected to login
   - This helped confirm session protection was working

2. Opened `checkout.php` directly
   - Missing POST data caused errors at first
   - Fixed it by validating `product_id` and `quantity`

3. Submitted fake `product_id`
   - Product lookup failed
   - Added database result checks before continuing

4. Tested invalid quantity values like `0` and negative numbers
   - Fixed it by requiring quantity to be at least 1

5. Opened `submit_order.php` directly
   - Added POST validation before inserts

6. Tested authenticated routes using `curl` with saved cookies
   - Confirmed protected pages only worked with a valid session

7. Tested direct access to `dashboard.php`
   - Found a redirect path issue in the subfolder setup
   - Fixed redirect paths to be more consistent

---

## Bugs I Fixed
- undefined array key warnings
- fake product submissions
- invalid quantity inserts
- logout redirect issues
- order history query mistakes
- GitHub secret exposure with `config.php`


---

## What I Learned
Biggest things I learned:
- always use `isset()` before reading request data
- a successful SQL query does not always mean a real record exists
- every protected page must check the session
- server-side validation is required even if HTML already restricts input
- `$mysqli->insert_id` is the right way to get the newest order ID
- user data should always be filtered by the logged-in account

---

## Next Improvements
Things I would like to add later:
- better CSS styling
- mobile-friendly layout
- shopping cart
- product search
- admin product management
- CSRF protection
- payment sandbox
- profile/settings page

---

## Final Goal
This project helped me get much more comfortable with authentication, session protection, debugging bad inputs, and making sure the backend stays safe even when users do unexpected things.

The biggest thing that stood out to me was how easy it was for the app to still “work” even when the logic was unsafe. Testing fake IDs, bad quantities, and direct route access showed me why every page needs its own validation.

## Next Steps
- Add role-based access control (Admin vs User)
- Build admin dashboard for product management
- Add password reset workflow
- Implement CSRF protection
- Improve UI styling with CSS
- Add product search and filters
- Add unit and integration tests
