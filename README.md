# 🏠 Sakani - Real Estate Management System

> A full-stack real estate management platform built to provide a modern and organized experience for property management, property discovery, reservations, and administration.

## 📌 About The Project

**Sakani** is a full-stack real estate management system designed to connect users with available properties while providing administrators with powerful tools to manage the platform.

The project combines a modern React frontend with a Laravel REST API backend and a relational database to provide a structured, scalable, and maintainable web application.

The system includes property management, reservations, user requests, image management, administrative controls, and statistics.

---

## ✨ Key Features

### 👤 User Features

- Browse available properties
- View detailed property information
- Search and explore properties
- Filter properties based on different criteria
- Submit reservation requests
- Send property-related requests
- Contact the platform
- Manage user interactions with the system

### 🏢 Property Management

- Create and manage properties
- Update property information
- Delete properties
- Manage property categories
- Manage property types
- Manage locations
- Manage amenities
- Upload and manage property images

### 🛠️ Admin Dashboard

- Dashboard overview
- Property management
- Category management
- Location management
- Amenity management
- Property type management
- Reservation request management
- User requests management
- Contact message management
- Platform settings
- Statistics and analytics

### 📊 Statistics & Analytics

The administration dashboard provides statistics and insights that help administrators monitor the platform and understand its activity.

---

## 🧰 Tech Stack

### Frontend

- React
- JavaScript
- HTML5
- CSS3
- Vite

### Backend

- PHP
- Laravel
- Laravel REST API

### Database

- MySQL

### Authentication & Security

- Laravel Sanctum
- API Authentication
- Protected Admin Routes
- Role-based access control

### Storage & Services

- Cloudinary
- RESTful APIs

### Development Tools

- Git
- GitHub
- VS Code
- Postman

---

## 🏗️ System Architecture

The project follows a client-server architecture:

```text
┌─────────────────────────────┐
│        React Frontend       │
│                             │
│  User Interface             │
│  Admin Dashboard            │
│  Property Pages             │
└──────────────┬──────────────┘
               │
               │ REST API
               ▼
┌─────────────────────────────┐
│       Laravel Backend       │
│                             │
│  Authentication             │
│  Business Logic             │
│  API Controllers            │
│  Validation                 │
│  Authorization              │
└──────────────┬──────────────┘
               │
               ▼
┌─────────────────────────────┐
│          MySQL              │
│                             │
│  Users                      │
│  Properties                 │
│  Reservations               │
│  Categories                 │
│  Locations                  │
│  Amenities                  │
│  Other Application Data     │
└─────────────────────────────┘
