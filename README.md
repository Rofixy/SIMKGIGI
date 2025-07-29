# SimKGIGI - Sistem Informasi Manajemen Klinik Gigi

SimKGigi is a comprehensive, web-based information system designed to streamline the management of dental clinics. Built with the Laravel framework, this application provides a robust platform for handling patient data, appointments, medical records, inventory, and administrative tasks.

The system is designed with a role-based access control system, catering to the specific needs of administrators, doctors, and patients.

## Core Features

### For Patients
- **User Registration:** New patients can register and create an account.
- **Profile Management:** Patients can view and update their personal information.
- **Appointment Booking:** Search for doctors and book appointments based on available schedules.
- **View Medical History:** Access their past visit records and treatment history.
- **Payment Tracking:** View transaction history and payment status.

### For Doctors
- **Personalized Dashboard:** A dedicated dashboard to view daily schedules and key metrics.
- **Schedule Management:** Doctors can create, update, and delete their own practice schedules.
- **Patient Anamnesis:** Input and manage patient consultation data, including complaints, examinations, diagnoses, and prescribed treatments (anamnesa).
- **View Patient Data:** Access the profiles and medical histories of their patients.

### For Administrators
- **Centralized Dashboard:** An overview of key clinic metrics, including total users and doctors.
- **User Management:** Full CRUD (Create, Read, Update, Delete) functionality for all user accounts (admins, doctors).
- **Doctor Management:** Add, edit, and manage doctor profiles, specializations, and photos.
- **Patient Management:** Access and manage all patient records.
- **Inventory Control:** Manage the clinic's medicine and supply inventory (data obat).
- **Financial Management:** Track all clinic transactions and view transaction details.
- **Reporting System:** Generate various reports for clinic management.

## Technology Stack

- **Backend:** PHP 8.1+, Laravel 10
- **Frontend:** Bootstrap 5, SASS, Vite
- **Database:** MySQL
- **Authentication:** Laravel UI, Laravel Sanctum
- **Roles & Permissions:** Spatie Laravel Permission

## Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & NPM
- A database server (e.g., MySQL)

### Installation

1.  **Clone the repository:**
    ```sh
    git clone https://github.com/rofixy/simkgigi.git
    cd simkgigi
    ```

2.  **Install PHP dependencies:**
    ```sh
    composer install
    ```

3.  **Create your environment file:**
    ```sh
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```sh
    php artisan key:generate
    ```

5.  **Configure your database:**
    Open the `.env` file and set your database connection details (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=simkgigi
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Run the database migrations:**
    This will create all the necessary tables in your database.
    ```sh
    php artisan migrate
    ```

7.  **Create the storage link:**
    ```sh
    php artisan storage:link
    ```

8.  **Install frontend dependencies:**
    ```sh
    npm install
    ```

9.  **Build frontend assets:**
    ```sh
    npm run build
    ```

10. **Run the development server:**
    ```sh
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

## Usage

The application features three main user roles: **Admin**, **Dokter** (Doctor), and **Pengguna** (Patient).

-   **Patient:** You can create a patient account by using the registration form.
-   **Admin & Doctor:** These roles must be assigned by an existing administrator. After installing the application, you can create a user through registration and then manually change their `role` in the `users` table in your database from `pengguna` to `admin` or `dokter` to access the respective dashboards and features.


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
