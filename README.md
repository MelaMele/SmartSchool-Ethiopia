# 🇪🇹 SmartSchool Ethiopia - School Management System

![Laravel](https://img.shields.io/badge/Laravel-8.x-red.svg)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-2.x-blue.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)
![Country](https://img.shields.io/badge/Localization-Ethiopia%20🇪🇹-yellow.svg)

**SmartSchool Ethiopia** ለኢትዮጵያ አንደኛ እና ሁለተኛ ደረጃ ትምህርት ቤቶች፣ እንዲሁም ለመዋዕለ-ህፃናት (KG) ተብሎ የተሰራ ዘመናዊ፣ ሁሉን-አቀፍ እና ፈጣን የትምህርት ቤት አስተዳደር ሲስተም (School Management System) ነው።

---

## 🌟 ዋና ዋና ገፅታዎች (Key Features)

- **📅 ሀገራዊ የቀን መቁጠሪያ እና ወራት:**
  - የኢትዮጵያ ዘመን አቆጣጠር (Andegna Ethiopian Calendar integration)።
  - ወርሃዊ ክፍያዎች በኢትዮጵያ ወራት (ከመስከረም እስከ ነሐሴ) የተደራጁ ናቸው።

- **🪪 የተማሪ መታወቂያ እና QR Code (ID Card Generator):**
  - ለእያንዳንዱ ተማሪ ቅደም ተከተሉን የጠበቀ መለያ ቁጥር (ለምሳሌ፡ `STD-2016-0001`) በራስ-ሰር ያመነጫል።
  - በሰከንዶች ውስጥ ለህትመት የተዘጋጀ የተማሪ መታወቂያ ከትክክለኛ **QR Code** ጋር ያዘጋጃል።

- **📊 የፈተና ውጤት እና የውጤት ካርድ (Continuous Assessment & Report Card):**
  - የፈተና፣ የኩዊዝ፣ የቤት ስራ፣ የሞዴል እና የማጠቃለያ ፈተና ውጤቶችን መመዝገቢያ።
  - የተማሪዎችን አማካይ (Average) እና ደረጃ (Rank) በራስ-ሰር አስልቶ ይፋዊ **Report Card** ያትማል።

- **🧾 የፋይናንስ እና የደረሰኝ ቁጥጥር (Finance & Cashier):**
  - ወርሃዊ የትምህርት ክፍያ፣ የምዝገባ፣ የማጠናከሪያ እና የትራንስፖርት/ሰርቪስ ክፍያዎችን መሰብሰቢያ።
  - የኢትዮጵያ የሽያጭ ደረሰኝ ቁጥር (**FS Number**) እንዳይደገም ጥብቅ ቁጥጥር ያደርጋል።

- **🗂️ ብልህ የሴክሽን ክፍፍል (Smart Sectioning Engine):**
  - ተማሪዎችን በክፍሉ የመያዝ አቅም (Room Capacity) መሰረት ወደ ሴክሽኖች (A, B, C...) በእኩልነት በራስ-ሰር ይመድባል።

- **🔐 የሚና እና የደህንነት ቁጥጥር (Role-Based Access Control):**
  - **Super Admin** (ዋና አስተዳዳሪ)
  - **Teacher** (መምህራን)
  - **Finance / Cashier** (የሂሳብ ክፍል)
  - **Parent** (ወላጆች)
  - **Student** (ተማሪዎች)

---

## 🛠️ የቴክኖሎጂ ምርጫዎች (Tech Stack)

- **Backend:** Laravel 8.x, PHP 7.4 / 8.0+
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
- **Database:** MySQL
- **Special Libraries:**
  - `andegna/calender` (የኢትዮጵያ ቀን መቁጠሪያ)
  - `simplesoftwareio/simple-qrcode` (QR Code Generator)
  - `haruncpi/laravel-id-generator` (Custom ID Generator)
  - `maatwebsite/excel` (Excel Import/Export)
  - `realrashid/sweet-alert` (Notifications)

---

## 🚀 ሲስተሙን በኮምፒውተር ላይ ለመጫን (Local Installation Guide)

ፕሮጀክቱን ወደ ኮምፒውተርህ አውርደህ ለመጠቀም የሚከተሉትን ትዕዛዞች በተርሚናል ላይ አስኬድ፦

```bash
# 1. ሪፖዚቶሪውን ክሎን አድርግ
git clone https://github.com/YOUR_USERNAME/SmartSchool-Ethiopia.git
cd SmartSchool-Ethiopia

# 2. የ PHP ላይብረሪዎችን ጫን
composer install

# 3. የ JavaScript እና CSS ላይብረሪዎችን ጫን
npm install
npm run dev

# 4. .env ፋይል አዘጋጅ እና ቁልፍ አመንጭ
cp .env.example .env
php artisan key:generate

# 5. ዳታቤዙን ፍጠር እና ሲደሮችን ጫን
php artisan migrate --seed

# 6. የፎቶ ማስቀመጫ ማገናኛ ፍጠር
php artisan storage:link

# 7. ሰርቨሩን አስጀምር
php artisan serve
