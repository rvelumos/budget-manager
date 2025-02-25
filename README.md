# Budget Manager App
A Laravel-based budget management application that allows users to track their incomes and expenses efficiently.

---

## Features
### 🔹 User Management
- User authentication (login, logout, registration).
- Each user has their own income and expense listings.
- Authorization ensures users can only manage their own data.

### 🔹 Income Management
- **Income Listings**: Organize multiple incomes into categorized lists.
- **Incomes**: Add individual income transactions under a listing.
- Create, edit, and delete income listings.
- Create, edit, and delete individual income transactions.
- Amount validation to prevent negative values.
- Users cannot delete or modify incomes from another user.

### 🔹 Expense Management
- **Expense Listings**: Organize multiple expenses into categorized lists.
- **Expenses**: Add individual expense transactions under a listing.
- Create, edit, and delete expense listings.
- Create, edit, and delete individual expense transactions.
- Users cannot delete or modify expenses from another user.

### 🔹 Budget Management
- Users can set monthly budgets for specific categories.
- Track budget usage and remaining balance.
- Warnings when approaching or exceeding budget limits.

### 🔹 Forecasting & Analytics
- Predict future expenses based on past trends.
- Graphs and charts to visualize spending patterns.
- Insights to optimize budget planning.

### 🔹 Admin Settings (For Admin Users)
- Manage users (create, edit, delete).
- Configure app settings (currency, tax rates, etc.).
- Define default categories for incomes and expenses.

### 🔹 Transactions Import
- Users can upload CSV files to import incomes and expenses.
- Error handling ensures invalid transactions are not processed.
- Imported transactions are categorized correctly.

### 🔹 Dashboard & Listings
- Overview of all income and expense listings.
- Each listing shows its associated transactions.
- Totals are calculated dynamically.
- Buttons to create new income/expense listings.
- Users can navigate between income and expense sections.

### 🔹 Authorization & Security
- Policies ensure users can only manage their own income and expenses.
- CSRF protection is enabled for form submissions.
- Middleware ensures only authenticated users can access financial data.

---

## 🛠 Installation
1. **Clone the repository**
   ```sh
   git clone https://github.com/rvelumos/budget-manager.git
   cd budget-manager

2. **Install dependencies**
    ```sh
    composer install
    npm install && npm run dev

3. **Set up environment**
    ```sh
    cp .env.example .env
    php artisan key:generate

4. **Configure database**
    ```sh
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=budget_manager
    DB_USERNAME=root
    DB_PASSWORD=password

5. **Run migrations and seeders**
    ```sh
    php artisan migrate --seed

6. **Start the application**
    ```sh
    php artisan serve

## 🛠 Installation (With Docker)

1. **Clone the repository**
   ```sh
   git clone https://github.com/rvelumos/budget-manager.git
   cd budget-manager
   
2. **Set up environment**
    ```sh
    cp .env.example .env
    php artisan key:generate
   
3. **Start Docker container**
    ```sh
    docker-compose up -d

4. **Run migrations and seeders**
    ```sh
    docker exec budgets-manager-app php artisan migrate --seed

- The app will be running at: http://127.0.0.1:8080
- Laravel backend (API) runs on: http://127.0.0.1:8000
- Database is available at: 127.0.0.1:3307
   
## Running tests

```sh
    php artisan test

