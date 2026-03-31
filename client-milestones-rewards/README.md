# Client Milestones Rewards – MVP

A Laravel-based web application that rewards Oshara clients when they reach important milestones in their journey.

Clients receive a **secure, unique email link** that leads to a personalized landing page where they can view and redeem their reward.

---

## 🎯 Project Goal

The goal of this project is to improve **client retention, loyalty, and perceived value** by offering meaningful, value-based rewards instead of discounts.

This is an MVP (Minimum Viable Product) focusing on:
- Secure reward links  
- Personalized client experience  
- One-time redemption  
- Basic support system  

---

## 🧠 Concept Overview

1. A client reaches a milestone (ex: 3, 6, or 12 months with Oshara)
2. The system generates a unique token and stores it in the database
3. The client receives an email with a secure link  
4. Clicking the link opens a **personalized reward page**
5. The client can redeem the reward **once**
6. The system logs when the link is opened and claimed

---

## ✨ Key Features (Client Side)

- Personalized reward landing page  
- Secure token-based access (non-guessable links)  
- One-time reward redemption  
- Expired and already-used link handling  
- Custom email sent with a “Discover Your Reward” button  
- Contact Support page  
- Support messages saved to database  
- Friendly UX (clear messaging, clean layout, Oshara-themed design)

---

## 🏆 Supported Milestones (MVP)

- 3 Months with Oshara  
- 6 Months with Oshara  
- 12 Months with Oshara  

---

## 🎁 Reward Types

- Free SEO or Technical Audit  
- Free Optimization or Improvement  
- Premium Report (SEO, Ads, Performance)  
- Strategic Consulting Call  
- Exclusive Resource (Guide, Checklist, Template)  

Each reward includes:
- Title  
- Short description  
- Instructions on how to redeem  

Rewards are assigned randomly per client.

---

## 🔐 Security Rules Implemented

- Each reward link is unique per client  
- Links are token-based and non-guessable  
- Links expire after a set time  
- Rewards can only be redeemed once  
- Invalid, expired, or used links show clear error pages  
- No public access without a valid token  

---

## 🛠️ Tech Stack

- Laravel 12  
- PHP 8.2  
- SQLite (local development)  
- Blade templates (frontend)  
- CSS (custom styling)  
- Laravel Mail (SMTP / Gmail / Mailtrap supported)  

---

## 👤 Author

**Built by:** Harkaran Singh Waraich  
**Project for:** Oshara Internship