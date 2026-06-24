# 📦 Boxify — Subscription Box Customization & Delivery Portal

A full-stack subscription box web application built from scratch using core web technologies — allowing users to choose plans, customize their boxes, track deliveries, and manage their subscriptions through a clean, secure portal.

---

## 🛠️ Tech Stack
`PHP` `HTML` `CSS` `JavaScript` `MySQL` `PDO` `OOP` `Bootstrap`

---

## ✨ Features

### 👤 User System
- Secure registration & login with **hashed passwords** (PASSWORD_DEFAULT)
- Session-based authentication with protected routes
- Profile management — update name, email, phone, shipping address & password
- Password reset via registered email
- Auto-generated **unique referral code** per user

### 📦 Subscription Plans
- Three tiered plans: **Standard** (3 items, 1 swap) | **Gold** (6 items, 3 swaps) | **VIP** (10 items, unlimited swaps)
- Plan enforcement — users cannot change plan once a subscription is active
- Item limit enforced per plan dynamically

### 🛒 Box Customization
- 30+ curated items across **Tech**, **Home**, and **Market** categories
- Duplicate item prevention within the same box
- Item swap system with swap counter per plan
- Real-time box management — add, swap, or clear items

### 🚚 Delivery Tracking
- Live delivery status (Ordered → Packing → Shipped)
- Progress bar UI for delivery stages
- Cancel box or cancel subscription from dashboard

### 🎁 Referral & Rewards System
- Unique referral code per user
- New users can register using a referral code
- Backend logic auto-calculates referral credits and discounts

### 🔒 Security
- PDO Prepared Statements — **SQL injection prevention**
- Encrypted passwords with PHP `password_hash()`
- Session management with route protection
- Input validation across all forms
- Admin access control

### 🛡️ Admin Panel
- Manage subscription plans (add / update / delete)
- Manage items (add / update / deactivate / delete)
- View all subscriptions, boxes, and deliveries
- Update delivery statuses

---

## 🗄️ Database Schema

**Tables:**
- `users` — id, full_name, email, password (hashed), referral_code, credits, phone, address
- `subscriptions` — id, user_id, plan_name, swaps_left, referral_code
- `subscription_items` — id, subscription_id, item_id

---

## 📋 Functional Requirements Coverage

| # | Requirement | Status |
|---|-------------|--------|
| FR-01 | User Registration | ✅ |
| FR-02 | User Login | ✅ |
| FR-03 | User Logout | ✅ |
| FR-04 | View Subscription Plans | ✅ |
| FR-05 | Select Subscription Plan | ✅ |
| FR-06 | Prevent Plan Change After Active Sub | ✅ |
| FR-07 | Customize Box | ✅ |
| FR-08 | Prevent Duplicate Item Selection | ✅ |
| FR-09 | Enforce Item Limit Per Plan | ✅ |
| FR-10 | Confirm Box & Create Subscription | ✅ |
| FR-11 | Cancel Box | ✅ |
| FR-12 | Cancel Subscription | ✅ |
| FR-13 | Track Delivery | ✅ |
| FR-14 | View Referral Code & Stats | ✅ |
| FR-15 | Register Using Referral Code | ✅ |
| FR-16 | Edit Profile | ✅ |
| FR-17 | Change Password | ✅ |
| FR-28 | Admin Manage Plans | ✅ |
| FR-29 | Admin Manage Items | ✅ |
| FR-30 | Admin Update Delivery Status | ✅ |

---

## 🚀 How to Run

1. Clone the repository
2. Import `schema.sql` into your MySQL database
3. Configure database credentials in `classes/Database.php`
4. Run on a local server (XAMPP / WAMP / Laragon)
5. Open `index.php` in your browser

---

## 📁 Project Structure

```
boxify/
├── index.php               # Landing page
├── register.php            # User registration
├── login.php               # User login
├── logout.php              # Session destroy
├── dashboard.php           # User dashboard & overview
├── subscribe.php           # Plan selection & box customization
├── profile.php             # Profile management
├── forgot_password.php     # Password reset
├── process_order.php       # Order processing API
├── schema.sql              # Full database schema
├── classes/
│   ├── Database.php        # PDO database connection
│   └── User.php            # User OOP class
├── includes/
│   ├── header.php
│   └── footer.php
└── api/
    └── manage_subscription.php
```

---

## 👥 Team Members

| Name | ID |
|------|----|
| Abdelrahman Elsayed Mohammed | 20240527 |
| Abdelrahman Salah Ahmed | 20240541 |
| Beshoy Ayman Obeid | 20230133 |
| Peter Ashraf Isaac | 20220117 |
| Khaled Mohammed Abdelfatah | 20240326 |
| Hassan Abdelrahman Hassan | 20210291 |

---

## 📚 Course
**Software Engineering** — Instructor: Ramadan


