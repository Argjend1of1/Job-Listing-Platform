# 💼 Job Listing Platform

A full-stack job board application built with Laravel that enables users to explore job opportunities and employers to manage listings. Featuring role-based access control, a RESTful API, and a modern JavaScript + Blade + Tailwind frontend, this system is designed for flexibility, security, and scalability.

## 🚀 Features

✅ **Role-based access**: User, Employer, SuperEmployer, Admin, SuperAdmin

🔐 **Authentication** via Laravel Sanctum (API & Web)

🧩 **RESTful API** with over 20 grouped endpoints

🧭 **Searchable and paginated** job listings

📄 **Resume** upload & application system

👥 **Admin tools** to promote or manage users

⚙️ **Dynamic middleware**-based route protection

🧱 **SQLite** support with easy database switching

🧪 **Unit & feature tests** for stability and validation

✏️ **Editable roles and permissions** via Admin panel

⚙️ Tech Stack
**Backend** Framework: Laravel 11+

**Database**: SQLite (default) – easily switchable to MySQL/PostgreSQL

**Frontend**: Blade, JavaScript, Tailwind CSS

**Authentication**: Laravel Sanctum (API + Web)

**Other**:

RESTful API

Eloquent ORM

Middleware for role control

File uploads (resumes)

Role-based access control

Pagination & filtering

GitHub for version control and PRs

GitHub Projects for task management

## 📁 Project Setup
 1. Clone & Navigate 
<pre>
    git clone https://github.com/yourusername/job-listing-platform.git 
    cd job-listing-platform
</pre>
2. Install Dependencies
<pre>
    composer install
    npm install && npm run build
</pre>
3. Configure Environment
<pre>
    cp .env.example .env
    php artisan key:generate
</pre>

Set database connection in .env:
<pre>
    DB_CONNECTION=sqlite
    DB_DATABASE=/absolute/path/to/database.sqlite
</pre>

Or switch to MySQL:
<pre>
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_DATABASE=your_db
    DB_USERNAME=root
    DB_PASSWORD=
</pre>

4. Migrate & Seed Database
<pre>
    php artisan migrate --seed
</pre>
5. Serve the App
<pre>
    php artisan serve
</pre>

## 👤 User Roles & Access
Role	            Abilities
User	            View & apply to jobs, upload resume
Employer	        Post/manage job listings
SuperEmployer	    Extended employer privileges
Admin	            Moderate jobs/users, edit roles
SuperAdmin	        Full control over the system

All roles are enforced via custom middleware in app/Http/Middleware.

📦 **API Highlights**
✔️ **20+ grouped endpoints**

Method	Endpoint	        Description
GET	/api/jobs	            List all jobs
GET	/api/jobs/{id}	        Get job detail
POST /api/jobs	            Create a new job (Employer)
POST /api/resume	        Upload resume (User)
PATCH /api/users/{id}/role	Promote user to admin

JSON format used for all responses

🧪 Running Tests
<pre>
    php artisan test
</pre>
You can find tests in:
**tests/Feature/**

## 📘Folder Highlights
**routes/api.php**: API endpoints

**routes/web.php**: Web routes

**app/Models/**: All Eloquent models

**app/Http/Middleware/**: Role-based access

**resources/views/**: Blade views

**database/migrations/**: DB schema logic

## 📝 License
This project is licensed under the MIT License.

## 👨‍💻 Contributors
Made by:
<pre>
    Argjend Nimanaj
    Alfred Palokaj
</pre>
    
Feel free to contribute via pull request!

