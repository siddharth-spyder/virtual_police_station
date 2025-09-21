# 🚔 Virtual Police Station - Tamil Nadu Government

A comprehensive web-based platform for online complaint registration and management system built with modern web technologies. This digital solution brings transparency, efficiency, and accessibility to law enforcement services for the citizens of Tamil Nadu.

## ✨ Features

### 🏛️ **Government-Grade Security & Compliance**
- Official Tamil Nadu Government themed interface
- Secure user authentication with password hashing
- Session management and data protection
- Multi-language support (Tamil, Hindi, English)

### 👥 **Dual User System**
- **Guest Complaints**: File complaints without registration
- **Registered Users**: Enhanced tracking and dashboard access
- **Admin Panel**: Complete complaint management system
- **Role-based access control**

### 📱 **Modern User Experience**
- Responsive design that works on all devices
- Real-time complaint status tracking
- Interactive dashboard with statistics
- Evidence photo upload with preview
- Intuitive complaint filing process

### 🔄 **Complaint Management**
- **Status Tracking**: Pending → In Progress → Resolved
- **Evidence Upload**: Multiple photo attachments support
- **Unique Complaint IDs**: Format #VPS000001
- **Admin Remarks**: Internal notes and updates
- **Email/SMS Notifications**: Status change alerts

### 📊 **Analytics & Reporting**
- Real-time statistics dashboard
- Complaint categorization and filtering
- Performance metrics for administrators
- User engagement tracking

## 🛠️ Technology Stack

### **Frontend**
- **HTML5** - Semantic markup and structure
- **CSS3** - Modern styling with CSS Grid and Flexbox
- **JavaScript** - Interactive features and form validation
- **Responsive Design** - Mobile-first approach

### **Backend**
- **PHP 7.4+** - Server-side logic and processing
- **MySQL 5.7+** - Robust database management
- **PDO** - Secure database interactions
- **Session Management** - User authentication

### **Server Environment**
- **Apache** - Web server (XAMPP/MAMP compatible)
- **File Upload System** - Evidence photo management
- **JSON Data Storage** - Flexible photo metadata

## 🚀 Quick Start

### Prerequisites
- XAMPP/MAMP/WAMP server environment
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/virtual-police-station.git
   cd virtual-police-station
   ```

2. **Set Up Database**
   ```bash
   # Import the database schema
   mysql -u root -p < database.sql
   ```

3. **Configure Database Connection**
   ```php
   // Update config.php with your database credentials
   $host = "localhost";
   $dbname = "vps_db";
   $username = "root";
   $password = "your_password";
   ```

4. **Set Up File Permissions**
   ```bash
   # Create uploads directory and set permissions
   mkdir uploads/complaints
   chmod 755 uploads/complaints
   ```

5. **Access the Application**
   ```
   http://localhost/virtual-police-station/
   ```

## 👤 Default Credentials

### Admin Access
- **Username**: `admin`
- **Password**: `admin123`
- **URL**: `http://localhost/virtual-police-station/admin/admin_login.php`

## 📁 Project Structure

```
virtual-police-station/
├── 📄 index.php              # Landing page with hero section
├── 📄 register.php           # User registration
├── 📄 login.php              # User authentication
├── 📄 logout.php             # Session termination
├── 📄 complaint.php          # Complaint filing form
├── 📄 dashboard.php          # User dashboard
├── 📄 config.php             # Database configuration
├── 📄 database.sql           # Database schema
├── 🎨 css/
│   └── style.css             # Tamil Nadu government styling
├── 📁 inc/
│   ├── header.php            # Common header component
│   └── footer.php            # Common footer component
├── 👨‍💼 admin/
│   ├── admin_login.php       # Admin authentication
│   ├── admin_dashboard.php   # Admin management panel
│   └── admin_logout.php      # Admin session termination
├── 🖼️ public/
│   └── logo.png              # Government logo
└── 📁 uploads/
    └── complaints/           # Evidence photo storage
```

## 🎯 Key Functionalities

### For Citizens
- **Easy Complaint Filing**: Simple 3-step process
- **Status Tracking**: Real-time updates on complaint progress
- **Evidence Upload**: Attach photos and documents
- **Dashboard Access**: View all complaints and statistics
- **Guest Mode**: File complaints without registration

### For Administrators
- **Complaint Management**: Update status and add remarks
- **Evidence Review**: View uploaded photos and documents
- **Statistics Dashboard**: Monitor system performance
- **User Management**: Track registered and guest users
- **Reporting Tools**: Generate insights and reports

## 🔒 Security Features

- **Password Hashing**: Secure user credential storage
- **SQL Injection Protection**: Prepared statements with PDO
- **File Upload Validation**: Secure evidence photo handling
- **Session Security**: Proper session management
- **Input Sanitization**: XSS protection
- **Role-based Access**: Admin and user separation

## 📱 Responsive Design

- **Mobile-First**: Optimized for smartphones and tablets
- **Cross-Browser**: Compatible with all modern browsers
- **Accessibility**: WCAG compliant design principles
- **Performance**: Optimized loading and rendering

## 🎨 **Design Features**
- **Tamil Nadu Government Theme**: Official color scheme and branding
- **Multilingual Text Elements**: Decorative Tamil and Hindi text for authenticity
- **Modern UI/UX**: Clean, professional interface design
- **Interactive Elements**: Hover effects and smooth transitions
## 🌐 Multi-Language Support

- **Tamil**: தமிழ் - Native language support
- **Hindi**: हिंदी - National language support  
- **English**: Primary interface language

## 📈 Performance Metrics

- **Fast Loading**: Optimized CSS and JavaScript
- **Database Efficiency**: Indexed queries and optimized schema
- **Image Optimization**: Compressed evidence photos
- **Caching**: Browser and server-side caching

## 🤝 Contributing

We welcome contributions from the community! Please read our contributing guidelines:

1. **Fork the repository**
2. **Create a feature branch** (`git checkout -b feature/amazing-feature`)
3. **Commit your changes** (`git commit -m 'Add amazing feature'`)
4. **Push to the branch** (`git push origin feature/amazing-feature`)
5. **Open a Pull Request**

### Development Guidelines
- Follow PSR-4 coding standards for PHP
- Use semantic HTML5 elements
- Write clean, commented code
- Test on multiple browsers and devices
- Ensure responsive design compatibility

## 📞 Support & Contact

- **Developer**: Academic Project
- **Purpose**: Educational demonstration of web-based complaint management system
- **Technology**: Full-stack PHP/MySQL application

## 🙏 Acknowledgments

- **Academic Institution** - For project guidance and evaluation
- **External Evaluators** - For assessment and feedback
- **Open Source Community** - For tools and libraries used
- **Web Development Community** - For best practices and inspiration

---

**Academic Project - Virtual Police Station Management System**
