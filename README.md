# Submission Task Fullstack

<img src="https://vuejs.org/images/logo.png" alt="Vue Logo" width="200px" /> <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" width="200px" />

## Installation

### Backend (Laravel)

#### Prerequisites
- PHP installed and configured
- Composer installed globally
- Laravel CLI installed

#### Installation Steps

1. **Clone the Laravel repository:**
   - Copy the repository URL from GitHub.
   - Open your terminal or command prompt.
   - Navigate to the directory where you want to clone the repository.
   - Use the `git clone` command followed by the repository URL:
     ```bash
     git clone https://github.com/username/laravel-project.git
     cd laravel-project
     ```

2. **Install PHP dependencies:**
   - Run the Composer install command to install required PHP packages:
     ```bash
     composer install
     ```

3. **Copy environment configuration:**
   - Make a copy of the `.env.example` file and rename it to `.env`:
     ```bash
     cp .env.example .env
     ```

4. **Generate application key:**
   - Use Artisan CLI to generate a new application key:
     ```bash
     php artisan key:generate
     ```

5. **Configure database:**
   - Open the `.env` file and set your database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_username
     DB_PASSWORD=your_database_password
     ```

6. **Run database migrations:**
   - Execute the migration command to create tables in the database:
     ```bash
     php artisan migrate
     ```

7. **Start the development server:**
   - Launch the Laravel development server:
     ```bash
     php artisan serve
     ```

### Frontend (Vue.js)

#### Prerequisites
- Node.js installed

#### Installation Steps

1. **Clone the Vue.js repository:**
   - Copy the repository URL from GitHub.
   - Open your terminal or command prompt.
   - Navigate to the directory where you want to clone the repository.
   - Use the `git clone` command followed by the repository URL:
     ```bash
     git clone https://github.com/username/vue-project.git
     cd vue-project
     ```

2. **Install Node.js dependencies:**
   - Use npm to install required dependencies:
     ```bash
     npm install
     ```

3. **Start the development server:**
   - Launch the Vue.js development server:
     ```bash
     npm run serve
     ```

4. **Access the application:**
   - Open your web browser and go to `http://localhost:8000` for the Laravel backend.
   - Open another terminal tab and navigate to the Vue.js project directory.
   - Access the Vue.js frontend at `http://localhost:8080`.

By following these steps, you can successfully set up Project X with both Laravel for the backend and Vue.js for the frontend.
