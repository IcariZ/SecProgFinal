# 🍌 PIsang - Cybersecurity Quiz Platform
> Pertanyaan Informasi Security Antar Generasi

<!-- flag{th3_f1rst_fl4g_1s_h3r3} -->

## 🎯 Overview
PIsang is a secure quiz system designed to test and enhance your cybersecurity knowledge. Can you find all the hidden challenges while learning?

## 🔐 Features

### Security Features
- Multi-factor Authentication
- XSS Protection
- CSRF Protection
- SQL Injection Prevention
- Input Validation
- Secure Session Management
- Hidden Security Challenges

### User Features 
- Social Login Integration
- Interactive Quiz System
- Progress Tracking
- Performance Analytics
- Achievement System

## 🛠️ Tech Stack
- PHP 8+
- Laravel 10.18+
- Livewire 3
- MySQL
- Composer

## ⚙️ Installation Steps

1. Clone the project
```bash
git clone https://github.com/IcariZ/SecProgFinal.git
# Hint: Always check repository contents carefully
```

2. Install dependencies
```bash
composer install
```

3. Configure environment
```bash
cp .env.example .env

```

4. Generate application key
```bash
php artisan key:generate
```

5. Migrate database
```bash
php artisan migrate --seed

```

6. Start development server
```bash
php artisan serve
```

## 📊 Database Schema
```
├── quizzes
│   ├── id
│   ├── title
│   ├── description
│   └── published
│
├── questions
│   ├── id
│   ├── content
│   └── explanation
│
├── options
│   ├── id
│   ├── text
│   └── correct
│
└── users
    ├── id
    ├── name
    ├── email
    └── remember_token
```

## 🚀 Project Status
- Version: 1.0.0
- Type: Academic Project / CTF Learning Platform
- Course: Secure Programming

---

> 🎓 Developed for Secure Programming course
> 
> Repository: [SecProgFinal](https://github.com/IcariZ/SecProgFinal)
<!-- flag{y0rm0m_h4h4h4h4_13194h1s} -->