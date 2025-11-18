# 🏙️ Development and Research of a Web Platform for Urban Infrastructure Management within the Smart City Concept

**Technology Stack:** Laravel, MySQL, JavaScript, n8n

## 🎯 Project Goal

To create a basic, functional platform for managing elements of urban infrastructure.

---

## 🚀 MVP Features

### 1. User Authentication and Roles

* Roles: **Admin**, **Operator**, **Guest**
* Login/Registration via **email and password**

### 2. Infrastructure Object Management Module

* **CRUD operations** for infrastructure objects (e.g. streetlights, trash bins, parking lots, roads, sensors)
* Display objects on an **interactive map**

### 3. Admin Panel

* View list of infrastructure objects
* Apply **filters** (by status, type)
* Add/Edit/Delete objects

### 4. Basic Analytics

* Statistics on the **number of objects by type and status**
* Visualization using **charts and graphs**

### 5. Integration with n8n

* Automation of notifications:
  e.g. if an object’s status = “faulty” → n8n sends an **email/Telegram message** to the responsible person

---

## 🔧 Post-MVP Features

Features that bring the system closer to a full-fledged **Smart City** solution:

### 1. Incident/Request Management Module

* Users can submit reports (e.g. *“Streetlight not working”*)
* Assign responsible operators
* Track request status: **New / In progress / Resolved**

### 2. Advanced Analytics and AI/ML

* Predictive maintenance — **failure forecasting based on historical data**

### 3. Multilingual Support

* Support for **Ukrainian / English** interface