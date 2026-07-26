# 🚀 MASTER PROJECT PROMPT: SMART SCHOOL LIBRARY MANAGEMENT SYSTEM

## 🧠 PROJECT OVERVIEW

Build a modern, offline-first School Library Management System using:

- Backend: Laravel (latest version)
- Database: MySQL
- Frontend: Blade (with option to integrate Vue later)
- Styling: Tailwind CSS
- Interactivity: Alpine.js (lightweight JS)

The system must support both:

1. 📚 Physical Library Management (core)
2. 💻 Digital Library (PDF-based, optional but integrated)

The UI must NOT look like a traditional admin dashboard.  
It should feel like a modern SaaS product (clean, minimal, premium) inspired by Notion/Linear-style interfaces.

---

## 🎯 CORE OBJECTIVES

- Digitize school library operations
- Provide clean and intuitive UI for librarians
- Support offline/local server usage (XAMPP/Laragon)
- Ensure scalability for future SaaS upgrade

---

## 🧱 SYSTEM MODULES

### 1. Dashboard
- Minimal overview (no clutter)
- Show:
  - Total books
  - Borrowed books
  - Overdue books
  - Recent activity

---

### 2. Books Module

#### Features:
- Add / Edit / Delete books
- Fields:
  - Title
  - Author
  - ISBN
  - Category
  - Quantity
  - Available Quantity
  - Shelf Location
  - Book Cover Image
  - Optional PDF file (for digital books)

#### UI:
- Large search bar
- Filter tabs:
  - All
  - Available
  - Borrowed
  - Digital
- Grid/List toggle
- Modern card-based catalog

---

### 3. Students Module

#### Features:
- Add / Edit students
- Fields:
  - Name
  - Class
  - Student ID
  - Phone (optional)
- View borrowing history

---

### 4. Transactions Module

#### Features:
- Borrow book
- Return book
- Track:
  - Issue date
  - Due date
  - Return date
  - Fine (if overdue)

#### Flow:
Step-based UI:
1. Select student
2. Select book
3. Confirm transaction

---

### 5. Librarians Module (IMPORTANT)

#### Features:
- Add / Edit / Deactivate librarians
- Fields:
  - Name
  - Email
  - Phone
  - Role (Head Librarian, Assistant)
  - Status (Active/Inactive)
  - Profile Photo (optional)

#### UI:
- Clean profile cards or list layout
- Click to view full profile

#### Advanced:
- Each librarian is also a system user (authentication)
- Track actions (who issued/received books)

---

### 6. Digital Library Module

#### Features:
- Upload PDF books
- Store locally (or configurable storage)
- Allow in-app viewing (PDF viewer)
- Restrict access to authorized users

---

## 🗃️ DATABASE DESIGN

Tables:

- books
- students
- librarians (linked to users table)
- users (authentication)
- transactions
- categories (optional)

Relationships:
- One student → many transactions
- One book → many transactions
- One librarian → many transactions

---

## 🔐 AUTHENTICATION & ROLES

Roles:
- Admin
- Librarian

Permissions:
- Admin: full access
- Librarian: limited (books, transactions)

---

## 🎨 UI/UX DESIGN PRINCIPLES

- No heavy sidebar (use minimal navigation)
- Use whitespace generously
- Soft shadows, subtle borders
- Smooth transitions (hover, click)
- Modern typography (Inter or Poppins)

---

## 🧩 UI STRUCTURE

### Layout:
- Top navigation bar OR slim sidebar
- Full-width content sections

---

### Pages:

1. Dashboard  
2. Books (catalog style)  
3. Book Details (like product page)  
4. Students  
5. Transactions (step-based flow)  
6. Librarians (profile system)  

---

## ✨ DESIGN INSPIRATION

- Clean workspace style (Notion-like)
- Minimal SaaS UI (Linear-like)
- Website-like sections (Stripe-like)

---

## ⚙️ FUNCTIONAL REQUIREMENTS

- Offline-first (runs on localhost)
- Fast search functionality
- Real-time UI updates (Alpine.js)
- File upload (book cover + PDF)
- Data validation
- Error handling

---

## 🚀 MVP PRIORITY (BUILD ORDER)

1. Authentication (Admin + Librarian)
2. Books module
3. Students module
4. Transactions (borrow/return logic)
5. Librarians module
6. Dashboard
7. Digital library (PDF)

---

## 💡 OPTIONAL ADVANCED FEATURES

- QR code for books
- Activity logs
- Fine automation
- Export reports (PDF/Excel)
- Dark mode

---

## 📦 DEPLOYMENT TARGET

- Local server (XAMPP/Laragon)
- Future upgrade path to cloud SaaS

---

## 🧠 FINAL NOTE

Focus on:
- Clean architecture
- Maintainable code
- Excellent UI/UX

Avoid:
- Overcomplicating early stages
- Cluttered dashboards
- Poor user experience

---

Build this as a premium product, not just a school project

---

## 🎓 NEW MODULE: INSTITUTIONAL REPOSITORY

**Objective:** Create a complete Institutional Repository module that allows the school library to archive and manage digital copies of students’ final-year projects after they have submitted them to the Nigerian NERD platform. Intended for local institutional storage and retrieval only.

**General Requirements:**
- Develop using existing Laravel architecture.
- Follow same coding standards, UI components, layout, auth, authorization policies, naming conventions.
- Must feel like a native part of the application.
- Do NOT rewrite or replace existing modules.

**Navigation:**
- Sidebar menu: "Institutional Repository"
  - Dashboard
  - Projects
  - Departments
  - Supervisors
  - Sessions
  - Search Repository
  - Statistics

**Dashboard:**
Total Projects, Projects by Department, Faculty, Session. Uploads this month. Recently added. Storage usage, Quick search, Recent activities.

**Database Design (New Tables):**
- `projects`: id, title, abstract, keywords, department_id, faculty_id, programme, session_id, supervisor_id, project_type, status, nerd_uploaded, nerd_reference, submission_date, approval_date, visibility, cover_image, pdf_path, created_by, updated_by, timestamps, softDeletes.
- `project_authors`: id, project_id, student_name, matric_number, email, phone, author_order, timestamps.
- `project_files`: id, project_id, file_type, file_name, file_path, file_size, mime_type, timestamps.
- `departments`: id, name, faculty_id, timestamps.
- `faculties`: id, name, timestamps.
- `supervisors`: id, name, department_id, email, timestamps.
- `academic_sessions`: id, session_name, start_year, end_year, is_active, timestamps.

**Project Form:**
Fields: Project Title, Abstract, Keywords, Faculty, Department, Programme, Academic Session, Supervisor, Project Type, Student Authors (dynamic rows), NERD Uploaded (Yes/No), NERD Ref Number, Submission Date, Visibility, Cover Image, PDF, Additional Files, Notes.

**Student Authors:**
Dynamic add/remove rows. Fields: Student Name, Matric Number, Email, Phone Number, Author Position.

**File Upload:**
- Use Laravel Storage (outside public folder).
- Unique filenames, validate uploads, configurable max PDF size.
- Never store PDF binary data in MySQL (only paths).

**Search:**
Advanced search with partial matching and pagination. Search by Title, Student Name, Matric Number, Department, Faculty, Supervisor, Academic Session, Keyword, Project Type, NERD Ref, Abstract.

**Repository Viewer:**
Detailed page for each project displaying all metadata, PDF download, Additional files, Related projects, Recently viewed.

**OPAC Integration:**
Extend existing OPAC so users can search Books, Institutional Repository, or Everything. Clearly indicate item type (Book vs Student Project). DO NOT merge projects into books table.

**Statistics:**
Charts for projects by faculty, department, year, session, most downloaded, most active departments, storage, recent trends.

**Permissions:**
Integrate with existing auth system. Permissions: Repository View, Create, Edit, Delete, Download, Approve, Manage Departments, Sessions, Supervisors, Reports.

**Validation, Performance, UI:**
Form requests, eager loading, pagination, proper indexes, existing design language (responsive desktop-first), printable reports (PDF/Excel/CSV), Activity Logging (created, updated, downloaded, etc.). Code quality (Laravel best practices, Resource controllers, Blade components, etc.).