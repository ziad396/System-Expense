# System-Expense
A simple System Expense
# Expense Management System

A simple Expense Management System built with Native PHP and MySQL.

## Features

* User Login
* Add Expense
* View Expenses
* Update Expense
* Delete Expense
* Search Expenses by Title
* Filter Expenses by Category
* Dashboard Statistics

  * Total Expenses
  * Total Amount
  * Average Expense
  * Categories Used

## Technologies Used

* PHP Native
* MySQL
* HTML
* CSS
* JavaScript

## Project Structure

```text
system_expense/
│
├── admin/
├── category/
├── expenses/
├── function/
├── user/
├── assets/
│
├── dashboard.php
├── expense.php
├── login.php
├── logout.php
├── index.php
│
├── database.sql
└── README.md
```

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/ziad396/System-Expense.git
```

### 2. Move Project

Place the project folder inside:

```text
xampp/htdocs/
```

### 3. Create Database

Open phpMyAdmin and create a database named:

```sql
system
```

### 4. Import Database

Import the file:

```text
database.sql
```

using phpMyAdmin.

### 5. Configure Database Connection

Open:

```text
function/connect.php
```

and update database credentials if needed.

Example:

```php
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "system"
);
```

### 6. Run Project

Start:

* Apache
* MySQL

Then open:

```text
http://localhost/system_expense
```

## Login Credentials

```text
Email: admin@arabapps.com
Password: 123456
```

## Database

The database schema is included in:

```text
database.sql
```

## Author

Ziad Ali Ibrahim Tayel

Backend Developer (PHP / Laravel)

