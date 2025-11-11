# MARIANCONNECT
## Official Website of St. Mary's College of Catbalogan (SMCC)

### 📋 Project Overview
MARIANCONNECT is a comprehensive web-based system designed to enhance the online presence, communication, and institutional identity of St. Mary's College of Catbalogan. This project was developed as a thesis requirement for Bachelor of Science in Computer Science.

**Developers:**
- ALBEZ, CHRISANTO S.
- AVILA, JUMAR S.
- DACUT, CATHERINE JOY L.
- ORBETA, HANNA MAY M.
- SAURO, ROD JUSTIN F.

**Date:** October 2025

---

## 🎨 Brand Colors
- **Primary Blue:** #1105FC
- **Primary Gold:** #FFD000
- **White:** #FFFFFF

---

## 🚀 Features

### User Features
- **Home Page** - Hero section with quick access links
- **About SMCC** - History, Vision, Mission, and Core Values
- **Academic Programs** - Basic Education and College Education programs
- **Admissions** - Requirements and enrollment process
- **News & Announcements** - Latest updates and events
- **Student Affairs** - Organizations and activities
- **Facilities** - Campus facilities with image gallery
- **Contact Us** - Contact information and location

### Admin Features
- **News Management** - Add, edit, and delete news articles
- **Admin Dashboard** - Content management system
- **User Analytics** - Track website visits and engagement

### Technical Features
- Responsive design (mobile, tablet, desktop)
- Search functionality
- Image gallery with filtering
- Admin authentication system
- MySQL database integration
- RESTful API for data management

---

## 💻 Technology Stack

### Frontend
- **HTML5** - Structure and semantic markup
- **CSS3** - Styling and responsive design
- **JavaScript (ES6)** - Interactive functionality

### Backend
- **PHP 7.4+** - Server-side programming
- **MySQL** - Database management

### Development Tools
- **XAMPP** - Local development environment
- **phpMyAdmin** - Database administration
- **Adobe Photoshop** - Image editing
- **Figma** - UI/UX design

---

## 📁 File Structure

```
marianconnect/
│
├── index.html              # Main HTML file
├── styles.css              # Main stylesheet
├── script.js               # Main JavaScript file
├── README.md               # This file
│
├── images/                 # Image assets
│   ├── smcc-logo.png      # College logo
│   ├── gallery/           # Gallery images
│   └── news/              # News images
│
├── php/                    # PHP backend files
│   ├── config.php         # Database configuration
│   ├── news.php           # News management API
│   ├── admin.php          # Admin authentication
│   └── analytics.php      # Website analytics
│
└── database/
    └── database.sql       # Database schema
```

---

## 🔧 Installation Instructions

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Web browser (Chrome, Firefox, Edge, Safari)
- Text editor (VS Code, Sublime Text, Notepad++)

### Step 1: Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP on your computer
3. Start Apache and MySQL from XAMPP Control Panel

### Step 2: Setup Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `marianconnect_db`
3. Import the `database.sql` file:
   - Click on `marianconnect_db` database
   - Go to "Import" tab
   - Choose `database/database.sql` file
   - Click "Go"

### Step 3: Configure Database Connection
1. Open `php/config.php`
2. Update database credentials if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'marianconnect_db');
   ```

### Step 4: Copy Files
1. Copy the entire `marianconnect` folder to:
   - Windows: `C:\xampp\htdocs\marianconnect`
   - Mac: `/Applications/XAMPP/htdocs/marianconnect`
   - Linux: `/opt/lampp/htdocs/marianconnect`

### Step 5: Add Your Logo
1. Place your SMCC logo in the `images/` folder
2. Rename it to `smcc-logo.png`
3. Recommended size: 200x200 pixels with transparent background

### Step 6: Access the Website
1. Open your web browser
2. Navigate to: `http://localhost/marianconnect`
3. The website should now be running!

---

## 👤 Admin Access

### Default Admin Credentials
- **Username:** admin
- **Password:** admin123

### Admin Features
1. **Login:** Click "Admin Panel" link on News page
2. **Add News:** Click "+ Add New Post" button
3. **Edit News:** Click edit button on any news item
4. **Delete News:** Click delete button on any news item

**⚠️ IMPORTANT:** Change the default password in production!

---

## 📊 Database Tables

### Main Tables
1. **news** - Stores news articles and announcements
2. **admin_users** - Admin account information
3. **gallery** - Gallery images and categories
4. **programs** - Academic programs
5. **contact_messages** - Contact form submissions
6. **analytics** - Website visit tracking

---

## 🎯 Testing the Website

### Functionality Checklist
- [ ] Home page loads correctly
- [ ] Navigation works on all pages
- [ ] Mobile menu works on small screens
- [ ] Search functionality works
- [ ] News displays correctly
- [ ] Programs tabs switch properly
- [ ] Gallery filter works
- [ ] Admin login works
- [ ] Add/Edit/Delete news works
- [ ] Responsive design works on mobile

---

## 🔐 Security Recommendations

### For Production Deployment
1. **Change Admin Password**
   - Use strong, unique password
   - Hash passwords using `password_hash()` in PHP

2. **Update Database Credentials**
   - Create a dedicated database user
   - Use strong password
   - Grant only necessary permissions

3. **Enable HTTPS**
   - Get SSL certificate
   - Force HTTPS connections

4. **Input Validation**
   - Validate all user inputs
   - Use prepared statements for SQL queries
   - Sanitize file uploads

5. **Session Security**
   - Set secure session parameters
   - Implement session timeout
   - Use CSRF tokens

---

## 🌐 Deployment to Live Server

### Steps for Live Deployment
1. **Choose a Web Host**
   - Shared hosting (Hostinger, Bluehost, etc.)
   - VPS (DigitalOcean, Linode, etc.)
   - Ensure PHP 7.4+ and MySQL support

2. **Upload Files**
   - Use FTP/SFTP client (FileZilla)
   - Upload all files to `public_html` or `www` folder

3. **Import Database**
   - Access phpMyAdmin on live server
   - Create database
   - Import `database.sql`

4. **Update config.php**
   - Update database credentials for live server
   - Update file paths if needed

5. **Test Everything**
   - Check all pages
   - Test admin functions
   - Verify mobile responsiveness

---

## 📱 Browser Compatibility

Tested and working on:
- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🐛 Troubleshooting

### Common Issues

**1. "Connection failed" error**
- Make sure MySQL is running in XAMPP
- Check database credentials in `config.php`
- Verify database exists

**2. Logo not displaying**
- Check if `smcc-logo.png` exists in `images/` folder
- Verify file path in `index.html`
- Check file permissions

**3. Admin login not working**
- Clear browser cache and cookies
- Check if admin user exists in database
- Verify password matches

**4. News not displaying**
- Check if database has sample data
- Open browser console for JavaScript errors
- Verify `script.js` is loading

**5. Page not found (404)**
- Verify folder structure
- Check XAMPP Apache is running
- Ensure files are in `htdocs` folder

---

## 📚 Additional Resources

### Learning Materials
- HTML/CSS: https://www.w3schools.com/
- JavaScript: https://javascript.info/
- PHP: https://www.php.net/manual/
- MySQL: https://dev.mysql.com/doc/

### Development Tools
- VS Code: https://code.visualstudio.com/
- FileZilla: https://filezilla-project.org/
- XAMPP: https://www.apachefriends.org/

---

## 📞 Support

For issues or questions:
- Contact the development team
- Email: marianconnect@smcc.edu.ph
- Refer to your thesis adviser

---

## 📄 License

This project was developed as a thesis requirement for St. Mary's College of Catbalogan.

**© 2025 St. Mary's College of Catbalogan. All Rights Reserved.**

---

## 🎓 Acknowledgments

We would like to thank:
- St. Mary's College of Catbalogan administration
- Our thesis adviser
- Faculty members of the Computer Science department
- Family and friends for their support

---

## 📝 Future Enhancements

Potential features for future versions:
- Online enrollment system
- Student portal
- Faculty portal
- Online payment integration
- Mobile app version
- Email notification system
- Events calendar with RSVP
- Alumni portal
- Job placement system
- E-learning integration

---

**Last Updated:** November 11, 2025  
**Version:** 1.0.0  
**Status:** ✅ Production Ready