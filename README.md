
#  OptiStaff 

**A lightweight, AI-integrated HR management system built with React (frontend) and Laravel (backend).**

---

## 📌 Project Overview

**OptiStaff** is a modular and efficient HR dashboard tailored for small to medium-sized businesses. Designed with both HR personnel and employees in mind, it simplifies administrative tasks and improves workplace productivity. With built-in AI-powered utilities and a clean, responsive user interface, OptiStaff streamlines HR operations for a better employee experience.

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
[![wakatime](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85.svg)](https://wakatime.com/badge/user/145cad6d-8c1b-4198-8921-1fa83c455eb5/project/53ff35ab-e8a9-46b6-886f-d0dcb6bc1f85)

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
- Automatic tracking of employee login times  
- Centralized admin dashboard with access to detailed attendance logs and exportable reports

### 🗓️ Leave Management
- Submit, review, and approve leave requests  
- Integrated holiday calendar view  
- Leave type and policy management (Admin)  

### 💰 Salary Management
- Admins can configure and manage salary details  
- Optional salary slip export feature  

---

## 🤖 AI-Powered Features

1. **AI Chatbot Assistant (24/7)**  
   - Integrated virtual HR assistant for instant help

2. **AI Interview Scheduling**  
   - Auto-scheduling based on calendar availability  
   

---

## 🔁 CRUD Operations

The system supports full **Create, Read, Update, Delete (CRUD)** operations:

| Module            | Actions Supported                 |
|-------------------|-----------------------------------|
| Employees         | Create, Read, Update, Delete      |
| Leave Requests    | Create, Read, Update, Delete      |
| Attendance Logs   | Create, Read, Update, Delete      |
| Salary Records    | Create, Read, Update, Delete      |

---

## 🔗 RESTful API Endpoints (Sample)

| Method | Endpoint               | Description                            |
|--------|------------------------|----------------------------------------|
| GET    | `/api/attendance`      | Retrieve employee attendance logs      |
| POST   | `/api/leave-request`   | Submit new leave application           |
| PUT    | `/api/salary/{id}`     | Update salary details (Admin)          |
| DELETE | `/api/employee/{id}`   | Remove employee profile (Admin only)   |

---

## 🔮 Future Enhancements

- **Automated Resume Screening**  
  AI models will analyze and shortlist CVs automatically, improving recruitment efficiency.

---

## 🛠️ Technology Stack

### 🔙 Backend
- **Laravel 8** (RESTful API)
- **Sanctum** (Authentication)
- **MySQL / SQLite** (Database)
- **BotMan / OpenAI API** (AI Layer)

### 🌐 Frontend
- **React.js**
- **React Router**
- **Axios** (API calls)
- **TailwindCSS / Material UI (MUI)**

### ⚙️ Rendering Method
- **Client-Side Rendering (CSR)**  
  Entire frontend rendered in the browser using React, consuming APIs from Laravel backend.

---

### 📷 Key Screens
- Login & Registration  
- Personalized Employee Dashboard  
- Attendance Dashboard for Real-Time Tracking 
- Admin Dashboard with full control over users and data  
---
### 🔗 UI Design Prototype (Canva)

View the full design on Canva:  
[🔗 OptiStaff Canva Design](https://www.canva.com/design/DAGuPKplmCY/N1-Me1XUxvJJgczGCB4NAg/view?utm_content=DAGuPKplmCY&utm_campaign=designshare&utm_medium=link2&utm_source=uniquelinks&utlId=hcc8ad85273)

---



## 📁 Project Structure

```

optistaff/
├── backend/             # Laravel 8 backend
│   ├── app/
│   ├── routes/
│   └── ...
├── frontend/            # React frontend
│   ├── src/
│   └── ...
├── .env                 # Environment configurations
└── README.md            # Project documentation

```

---

## 👩‍💻 Contributors

- Quazi Zarin Subah (ID - 20220204079)  
- Arpa Adhikary Tathai (ID - 20220204094) 
- Zarin Tasnim Ahmed (ID - 20220204096) 
- Prionty Saha (ID - 20220204106) 

---

## 📄 License

This project is built for **CSE2100 Software Development Lab-IV** and is intended for academic use.



