# OptiStaff

**A lightweight, AI-integrated HR management system built with Laravel and Blade.**

---

# Team Members:

- Quazi Zarin Subah      | zarin.cse.20220204079@aust.edu
- Arpa Adhikary Tathai   | arpa.cse.20220204094@aust.edu
- Zarin Tasnim Ahmed     | zarin.cse.20220204096@aust.edu
- Prionty Saha           | prionty.cse.20220204106@aust.edu

---

# Project Live Link: [Insert URL]
# Recorded video: [Insert URL] (Optional)

---

## Table of Contents

1. Project Description
2. Workflow Overview
3. Main Features
4. Technologies Used
5. System Architecture
6. Setup Guidelines
7. Running the Application
8. Deployment Status & Tests
9. Contribution Table
10. Screenshots
11. Limitations / Known Issues

---

## 1. Project Description

**OptiStaff** s a modular and efficient HR dashboard tailored for small to medium-sized businesses. Designed with both HR personnel and employees in mind, it simplifies administrative tasks and improves workplace productivity. With a built-in AI-powered chatbot and a clean, responsive user interface, OptiStaff streamlines HR operations for a better employee experience.


---

## 2. Workflow Overview

The application follows a standard web application workflow:

- Users can register as either an 'admin' or a 'user'.
- Upon successful login, users are redirected to their respective dashboards based on their role.
- Admin Dashboard: Provides an overview of daily attendance, access to manage employees, attendance, leave requests, and company   holidays. Admins can also interact with the AI HR Assistant.
- Employee Dashboard: Shows a personalized summary of attendance, leave balance, and upcoming events. Employees can request leave, view their attendance, and see company policies.
- Users can manage their profiles, including updating their information and password.


---

## 3. Main Features 

### Feature 1: 🔐 User Authentication

- Secure login with **role-based access**
- Admin panel for HR management
- Employee panel for self-service tools

### Feature 2: 📊 Dashboard System

- Role-specific dashboards (Admin vs Employee)
- Personalized summary cards and quick actions

### Feature 3: ⏱️ Attendance Management

- Track employee attendance (Present, Absent, Late, Leave)
- Lock and unlock attendance periods for data integrity
- Generate performance reports based on attendance data

### Feature 4: 🗓️ Leave Management

- Submit, review, and approve leave requests
- Integrated holiday calendar view
- Manage company holidays (Admin)

### Feature 5: 🤖 AI-Powered Features

 **AI HR Analytics Chatbot**

   - Integrated virtual HR assistant for instant insights on HR data using natural language queries

--- 

## 4. Technologies Used

### 🔙 Backend

- **Laravel** (MVC Framework)
- **Blade** (Templating Engine)
- **MySQL/MariaDB** (Database)

### 🌐 Frontend

- **HTML/CSS**
- **JavaScript**
- **Alpine.js**
- **TailwindCSS**

---

## 5. System Architecture

- The application is built using the MVC (Model-View-Controller) architecture provided by Laravel.

optistaff/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── tests/
└── vendor/         
└── README.md            

---

## 6. Setup Guidelines

### Backend & Frontend (Integrated)

# Clone the repository
git clone <repo-url>
cd optistaff

# Install dependencies
composer install
npm install

# Setup environment variables
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in the .env file

# Run database migrations
php artisan migrate

# Seed the database
php artisan db:seed

# Build frontend assets
npm run dev

---

## 7. Running the Application

# To run the application locally, use the following command:
php artisan serve

---

## 8. Deployment Status & Tests

| Component | Is Deployed? | Is Dockerized? | Unit Tests Added? (Optional)  | Is AI feature implemented? (Optional) |
|-----------|--------------|----------------|------------------------------ |--------------------------             |
| Backend   |    Yes       |         Yes    |  No                           | Yes                                   |
| Frontend  |    Yes       |         Yes    |  No                            | Yes                                  |

---


## 9. Contribution Table

| Metric                       | Total | Backend | Frontend | Member 1 | Member 2 | Member 3 | Member 4 |
|----------------------------- |-------|---------|----------|----------|----------|----------|----------|
| Issues Solved                |       |         |          |          |          |          |          |
| WakaTime Contribution (Hours)|       |         |          |          |          |          |          |
| Percent Contribution (%)     |       |         |          |          |          |          |          |

---

## 10. Screenshots

*Include screenshots or GIFs of the deployed application.*

---


## 11. Limitations / Known Issues

- The AI chatbot's capabilities are currently limited to a predefined set of queries.
- The application does not yet have unit or feature tests.

---
 # Time contribution- 

**Quazi Zarin Subah** (ID: 20220204079)  
[![wakatime](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85.svg)](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85)

**Arpa Adhikary Tathai** (ID: 20220204094)  
[![wakatime](https://wakatime.com/badge/user/e0ed99f9-5f30-4f27-9920-703655de3846/project/319e9e2f-fa6b-4821-b21c-0f1eb969aa81.svg)](https://wakatime.com/badge/user/e0ed99f9-5f30-4f27-9920-703655de3846/project/319e9e2f-fa6b-4821-b21c-0f1eb969aa81)

**Zarin Tasnim Ahmed** (ID: 20220204096)  
[![wakatime](https://wakatime.com/badge/user/21fea1a3-79be-4a16-99bd-d0bf8076959b/project/da6ddc39-bf0b-4995-b28e-4675c3e35905.svg)](https://wakatime.com/badge/user/21fea1a3-79be-4a16-99bd-d0bf8076959b/project/da6ddc39-bf0b-4995-b28e-4675c3e35905)

**Prionty Saha** (ID: 20220204106)  
[![wakatime](https://wakatime.com/badge/user/3944b5f4-3bb5-4f43-a702-0fcf1e7bd0e9/project/e21298b2-1a34-47ba-96b9-50fb855f389f.svg)](https://wakatime.com/badge/user/3944b5f4-3bb5-4f43-a702-0fcf1e7bd0e9/project/e21298b2-1a34-47ba-96b9-50fb855f389f)

---

This project is built for **CSE3100 Software Development Lab-IV** and is intended for academic use.
