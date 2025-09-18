# OptiStaff

**A lightweight, AI-integrated HR management system built with Laravel and Blade.**

---

## 📌 Project Overview

**OptiStaff** is a modular and efficient HR dashboard tailored for small to medium-sized businesses. Designed with both HR personnel and employees in mind, it simplifies administrative tasks and improves workplace productivity. With a built-in AI-powered chatbot and a clean, responsive user interface, OptiStaff streamlines HR operations for a better employee experience.

---

## 🎯 Objective

The primary goal of **OptiStaff** is to reduce the repetitive workload on HR staff by integrating AI-assisted tools while empowering employees with a user-friendly self-service platform. From leave requests to onboarding, the platform handles day-to-day HR needs with ease and intelligence.

Key highlights include:

- Seamless attendance tracking for accurate record-keeping
- Effortless leave management with real-time approval workflows
- Smart meeting coordination based on team availability
- Role-specific dashboards for HR managers and employees for optimized access

---

## 📊 Development Activity

Track real-time coding progress:  

**Quazi Zarin Subah** (ID: 20220204079)  
[![wakatime](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85.svg)](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85)

**Arpa Adhikary Tathai** (ID: 20220204094)  
[![wakatime](https://wakatime.com/badge/user/e0ed99f9-5f30-4f27-9920-703655de3846/project/319e9e2f-fa6b-4821-b21c-0f1eb969aa81.svg)](https://wakatime.com/badge/user/e0ed99f9-5f30-4f27-9920-703655de3846/project/319e9e2f-fa6b-4821-b21c-0f1eb969aa81)

**Zarin Tasnim Ahmed** (ID: 20220204096)  
[![wakatime](https://wakatime.com/badge/user/21fea1a3-79be-4a16-99bd-d0bf8076959b/project/da6ddc39-bf0b-4995-b28e-4675c3e35905.svg)](https://wakatime.com/badge/user/21fea1a3-79be-4a16-99bd-d0bf8076959b/project/da6ddc39-bf0b-4995-b28e-4675c3e35905)

**Prionty Saha** (ID: 20220204106)  
[![wakatime](https://wakatime.com/badge/user/3944b5f4-3bb5-4f43-a702-0fcf1e7bd0e9/project/e21298b2-1a34-47ba-96b9-50fb855f389f.svg)](https://wakatime.com/badge/user/3944b5f4-3bb5-4f43-a702-0fcf1e7bd0e9/project/e21298b2-1a34-47ba-96b9-50fb855f389f)

---

## 👥 Target Audience

- HR teams in small to mid-sized organizations
- Businesses aiming for efficient employee management
- Employees needing a centralized HR self-service portal

---

## 🧩 Core Features & Role-Based Access

### 🔐 User Authentication

- Secure login with **role-based access**
- Admin panel for HR management
- Employee panel for self-service tools

### 📊 Dashboard System

- Role-specific dashboards (Admin vs Employee)
- Personalized summary cards and quick actions

### ⏱️ Attendance Management

- Track employee attendance (Present, Absent, Late, Leave)
- Lock and unlock attendance periods for data integrity
- Generate performance reports based on attendance data

### 🗓️ Leave Management

- Submit, review, and approve leave requests
- Integrated holiday calendar view
- Manage company holidays (Admin)

### 🤖 AI-Powered Features

1. **AI HR Analytics Chatbot**

   - Integrated virtual HR assistant for instant insights on HR data using natural language queries

## 🔁 CRUD Operations

The system supports full **Create, Read, Update, Delete (CRUD)** operations:

| Module          | Actions Supported            |
| --------------- | ---------------------------- |
| Employees       | Create, Read, Update, Delete |
| Leave Requests  | Create, Read, Update, Delete |
| Attendance Logs | Create, Read, Update, Delete |
| Salary Records  | Create, Read, Update, Delete |

---

## 🔗 RESTful API Endpoints (Sample)

| Method | Endpoint             | Description                          |
| ------ | -------------------- | ------------------------------------ |
| GET    | `/api/attendance`    | Retrieve employee attendance logs    |
| POST   | `/leave`             | Submit new leave application         |
| PUT    | `/holidays/{id}`     | Update holiday details (Admin).      |
| DELETE | `/profile`           | Delete the user's account.           |

---

## 🔮 Future Enhancements

- **Automated Resume Screening**  
  AI models will analyze and shortlist CVs automatically, improving recruitment efficiency.

---

## 🛠️ Technology Stack

### 🔙 Backend

- **Laravel** (MVC Framework)
- **Blade** (Templating Engine)
- **MySQL/MariaDB** (Database)

### 🌐 Frontend

- **HTML/CSS**
- **JavaScript**
- **Alpine.js**
- **TailwindCSS**

### ⚙️ Rendering Method

- **Server-Side Rendering (SSR)**
The entire frontend is rendered on the server using Laravel's Blade templating engine, with Alpine.js managing frontend interactivity. This approach ensures fast initial page loads and a tightly integrated system.
---

### 📷 Key Screens

- Login & Registration
- ersonalized Employee Dashboard
- Admin Dashboard with an overview of daily attendance and access to management features
- Attendance and Leave Management pages

---

### 🔗 UI Design Prototype (Canva)

View the full design on Canva:  
[🔗 OptiStaff Canva Design](https://www.canva.com/design/DAGuPKplmCY/N1-Me1XUxvJJgczGCB4NAg/view?utm_content=DAGuPKplmCY&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=hcc8ad85273)

---

## 📁 Project Structure

```

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
└── README.md            # Project documentation

```

## 👩‍💻 Contributors

- Quazi Zarin Subah (ID - 20220204079)
- Arpa Adhikary Tathai (ID - 20220204094)
- Zarin Tasnim Ahmed (ID - 20220204096)
- Prionty Saha (ID - 20220204106)

---

## 📄 License

This project is built for **CSE3100 Software Development Lab-IV** and is intended for academic use.
