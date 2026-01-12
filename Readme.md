# JA Square Business Card Designer
**Version:** 1.7.0  
**Author:** Salim Nazir  
**Powered By:** JA Square Marketplace

A high-fidelity, professional web-based design suite built with **Fabric.js** and **Material Design 3 (M3)** principles. This tool allows users to create custom business card layouts using a mix of remote assets, local files, and advanced typography controls.

---

## 🚀 Key Features

### 🎨 Creative Tools
* **Web Image Loader:** Directly load background images or logos using URLs.
* **Manual Upload:** Support for local `.jpg`, `.png`, and `.svg` file uploads.
* **Advanced Typography:** * Support for Google Fonts (Roboto, Montserrat, Pacifico, etc.).
    * Real-time Color Fill and Outline (Stroke) color pickers.
    * **Outline Thickness:** Precision slider to adjust text stroke size (0–10px).
* **Glassmorphism UI:** A sleek, modern interface with 32px high-density corners and soft elevation.

### 🛠 Professional Controls
* **Z-Index Layering:** Move objects to the front or back with a single click.
* **Visual Filters:** Apply Opacity and Gaussian Blur to any layer (including the background).
* **50/50 Split Layout:** Optimized for desktop and tablet screens to ensure zero scrolling while designing.

### 💾 Export & Persistence
* **PNG Download:** Export high-resolution designs directly to your computer.
* **Print Ready:** Integrated CSS print-media queries for physical card production.
* **Database Sync:** Automatically saves the design state (JSON) to the database via `save_card.php`.

---

## 🛠 Tech Stack
* **Frontend:** HTML5, CSS3 (Glassmorphism), JavaScript (ES6)
* **Canvas Engine:** [Fabric.js v5.3.1](http://fabricjs.com/)
* **Backend:** PHP 8.x
* **Database:** MySQL / MariaDB
* **Design Language:** Google Material Design 3

---

## ⚙️ Installation & Setup

1.  **Clone the Repository**

2.  **Database Configuration**
    * Edit `db_connect.php` with your credentials.
    * Run `db_setup.php` to initialize the tables. *Note: This script will drop and recreate tables on every run.*

---

## 📁 File Structure
- `index.php`: The main designer interface.
- `db_connect.php`: Database connection logic.
- `db_setup.php`: Database table initialization.
- `save_card.php`: API endpoint for saving design JSON.

---

## 📜 License
© 2026 Salim Nazir | JA Square Marketplace. All rights reserved.
