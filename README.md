🚀 Random User Ingestion & Dynamic Filter API
-----------------------------------------------------

Production-style Laravel application demonstrating:
------------------------------------------------------
Scheduled background data ingestion
Normalized relational database design
Dynamic filtering via Eloquent ORM
Sparse field selection (custom response fields)
Transaction-safe writes
Clean architecture layering

📌 Overview
--------------
This system:

Fetches random users every 5 minutes from:
https://randomuser.me/api/

Stores them in a normalized relational structure:
users
user_details
locations

Exposes a public REST API that:

Filters users by gender, city, country
Limits number of records
Allows dynamic field selection
Returns clean JSON responses

🏗 High-Level Architecture
------------------------------

🔷 System Flow
--------------------
Laravel Scheduler (every 5 minutes)
            │
            ▼
FetchAddRandomUsers Command
            │
            ▼
Laravel HTTP Client → randomuser.me API
            │
            ▼
Database Transaction
    ├── users
    ├── user_details
    └── locations
            │
            ▼
Public API (/api/users)
            │
            ▼
Filtered & Dynamic JSON Response

🧱 Logical Architecture Layers
-------------------------------------
┌─────────────────────────────────────┐
│ Presentation Layer                  │
│ API Route → UserController@index    │
│ UserResource (Response Formatting)  │
└─────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────┐
│ Application Layer                   │
│ FetchAddRandomUsers Command         │
│ Scheduler                           │
└─────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────┐
│ Domain Layer                        │
│ User Model                          │
│ UserDetail Model                    │
│ Location Model                      │
│ ORM Relationships                   │
└─────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────┐
│ Infrastructure Layer                │
│ MySQL Database                      │
│ External API (randomuser.me)        │
└─────────────────────────────────────┘

🗄 Database Design
--------------------------
Normalized Schema (3NF)

users
---------
Column	    Type
id	        bigint (PK)
name	    string
email	    string (unique)
password	string
timestamps

user_details
---------------
Column	    Type
id	        bigint
user_id	    FK → users.id
gender	    string
timestamps

locations
---------------
Column	    Type
id	        bigint
user_id	    FK → users.id
city	    string
country	    string
timestamps


🔎 Design Decisions
--------------------------
Normalized relational modeling
Foreign key constraints
Cascade delete protection
Email uniqueness enforcement
ORM relationship mapping
Indexed foreign keys for filtering

⚙️ Installation & Setup
--------------------------

1️⃣ Clone Repository
git clone <repo-url>
cd project-name

2️⃣ Install Dependencies
composer install

3️⃣ Environment Setup
cp .env.example .env
php artisan key:generate

Update .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coding_test
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Database Setup
CREATE DATABASE coding_test;
php artisan migrate

⏰ Scheduled Data Ingestion Command
----------------------------------------

php artisan app:fetch-add-random-users
Scheduler Definition
Schedule::command('app:fetch-add-random-users')->everyFiveMinutes();

Local Development
php artisan schedule:work

Production Cron
* * * * * php /path-to-project/artisan schedule:run >> /dev/null 2>&1

🌐 Public API
--------------------

Endpoint
GET /api/users

🔎 Filtering Parameters
-------------------------

Parameter	Description
gender	    male / female
city	    Filter by city
country	    Filter by country
limit	    Number of records
fields	    Specify returned fields

📌 Dynamic Field Selection (Sparse Fieldsets)
--------------------------------------------------
Clients can control response fields:

GET /api/users?fields=name,email
GET /api/users?fields=name,email,city

Allowed fields:
-------------------

name
email
gender
city
country

This is handled via Laravel API Resources with field whitelisting.

📌 Example Requests
-------------------------
Filter by Gender
GET /api/users?gender=male

Filter by Country + Limit
GET /api/users?country=India&limit=5

Only Name + Email
GET /api/users?fields=name,email

📌 Sample Response
[
  {
    "name": "John Doe",
    "email": "john@example.com",
    "gender": "male",
    "city": "London",
    "country": "United Kingdom"
  }
]

🔍 Query Optimization Strategy
----------------------------------

whereHas() for relationship filtering
with() for eager loading
Controlled limit
Field whitelisting
No N+1 queries
No unnecessary joins
Prevents over-fetching

🔐 Security Considerations
---------------------------------

Mass assignment protection
Field-level response control
Email uniqueness constraint
No sensitive attributes exposed
Transactional integrity

🧪 Suggested Testing Strategy
---------------------------------

Feature tests for API filters
Feature tests for sparse fields
Command tests for ingestion
Database assertions
API response structure validation

📦 Technology Stack
---------------------------
Laravel (latest stable)
MySQL
Eloquent ORM
Laravel Scheduler
Laravel HTTP Client

🎯 Engineering Principles Demonstrated
------------------------------------------

Clean separation of concerns
Transactional consistency
Normalized relational modeling
Background task automation
Dynamic query filtering
Sparse field API design
Production-ready structure

👨‍💻 Author
----------------
Backend engineering coding exercise demonstrating:
Laravel architecture expertise
Database design best practices
RESTful API design
Scheduled background processing
Advanced Eloquent ORM usage
