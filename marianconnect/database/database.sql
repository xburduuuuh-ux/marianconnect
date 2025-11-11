-- MARIANCONNECT Database Schema
-- St. Mary's College of Catbalogan
-- 
-- Instructions:
-- 1. Open phpMyAdmin in your XAMPP
-- 2. Create a new database named 'marianconnect_db'
-- 3. Import this SQL file or run these queries

-- Create database
CREATE DATABASE IF NOT EXISTS marianconnect_db;
USE marianconnect_db;

-- ===================================
-- News Table
-- ===================================
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    category VARCHAR(50) NOT NULL,
    excerpt TEXT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (date),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Admin Users Table
-- ===================================
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Gallery Table
-- ===================================
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    image_path VARCHAR(255),
    description TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Programs Table
-- ===================================
CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    program_name VARCHAR(255) NOT NULL,
    program_code VARCHAR(20) NOT NULL,
    level VARCHAR(50) NOT NULL, -- 'basic' or 'college'
    description TEXT,
    duration VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_level (level)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Contact Messages Table
-- ===================================
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    replied BOOLEAN DEFAULT FALSE,
    INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Website Analytics Table
-- ===================================
CREATE TABLE IF NOT EXISTS analytics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_url VARCHAR(255) NOT NULL,
    page_title VARCHAR(255),
    referrer VARCHAR(255),
    visitor_ip VARCHAR(45),
    user_agent TEXT,
    visit_date DATE NOT NULL,
    visit_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_date (visit_date),
    INDEX idx_page (page_url),
    INDEX idx_referrer (referrer)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Admin Activity Log Table
-- ===================================
CREATE TABLE IF NOT EXISTS admin_activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_admin (admin_id),
    INDEX idx_date (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- Insert Sample Data
-- ===================================

-- Sample News Data
INSERT INTO news (title, date, category, excerpt, content) VALUES
('SMCC Celebrates Foundation Day 2025', '2025-10-15', 'Events', 
'St. Mary\'s College of Catbalogan commemorates another year of academic excellence and service to the community.',
'The institution held a week-long celebration featuring academic competitions, cultural performances, and community outreach programs. Students, faculty, and alumni gathered to celebrate the rich history and achievements of SMCC.'),

('New Computer Laboratory Opens', '2025-09-20', 'Facilities',
'State-of-the-art computer lab now available for BSCS students.',
'The new facility features 50 high-performance computers with the latest software for programming and development. This investment in technology ensures that our students receive hands-on training with industry-standard tools.'),

('SMCC Students Win Regional Competition', '2025-08-10', 'Achievements',
'College of Computer Science students bring home awards from regional tech competition.',
'The team showcased innovative solutions in software development and earned recognition for their outstanding performance. This achievement highlights the quality education and mentorship provided at SMCC.'),

('Enrollment for SY 2025-2026 Now Open', '2025-04-01', 'Announcements',
'SMCC is now accepting enrollees for the upcoming school year.',
'Interested students can visit the Admissions Office or contact us through our official channels. Early enrollment is encouraged to secure slots in your preferred programs.'),

('SMCC Holds Community Outreach Program', '2025-07-15', 'Events',
'Students and faculty reach out to local communities through various service activities.',
'The outreach program included medical missions, feeding programs, and educational seminars. This initiative reflects SMCC\'s commitment to social responsibility and community service.'),

('Library Expands Digital Collection', '2025-06-20', 'Facilities',
'SMCC Library now offers more e-books and online research databases.',
'Students and faculty now have access to thousands of digital resources for research and learning. The expanded collection includes academic journals, e-books, and multimedia materials.');

-- Sample Admin User (password: admin123 - in production, use hashed passwords)
INSERT INTO admin_users (username, password, email, full_name) VALUES
('admin', 'admin123', 'admin@smcc.edu.ph', 'System Administrator');

-- Sample Programs Data - Basic Education
INSERT INTO programs (program_name, program_code, level, description, duration) VALUES
('Kindergarten', 'KINDER', 'basic', 'Foundation for lifelong learning through play-based and interactive activities.', '1 year'),
('Grade School', 'GS', 'basic', 'Building strong fundamentals in core subjects and developing essential skills.', 'Grades 1-6'),
('Junior High School', 'JHS', 'basic', 'Developing critical thinking and preparing students for Senior High School.', 'Grades 7-10'),
('Senior High - STEM', 'SHS-STEM', 'basic', 'Science, Technology, Engineering, and Mathematics track for future engineers and scientists.', 'Grades 11-12'),
('Senior High - ABM', 'SHS-ABM', 'basic', 'Accountancy, Business, and Management track for aspiring entrepreneurs.', 'Grades 11-12'),
('Senior High - HUMSS', 'SHS-HUMSS', 'basic', 'Humanities and Social Sciences track for students interested in social work and education.', 'Grades 11-12'),
('Senior High - ICT', 'SHS-ICT', 'basic', 'Information and Communications Technology track for future IT professionals.', 'Grades 11-12');

-- Sample Programs Data - College Education
INSERT INTO programs (program_name, program_code, level, description, duration) VALUES
('BS in Computer Science', 'BSCS', 'college', '4-year program preparing students for careers in software development, programming, and IT.', '4 years'),
('BS in Accountancy', 'BSA', 'college', '4-year program leading to CPA certification and careers in accounting and finance.', '4 years'),
('BS in Business Management', 'BSBM', 'college', '4-year program developing future business leaders and entrepreneurs.', '4 years'),
('BS in Hospitality Management', 'BSHM', 'college', '4-year program for careers in hotels, restaurants, and tourism industry.', '4 years'),
('Bachelor of Elementary Education', 'BEED', 'college', '4-year program preparing future elementary school teachers.', '4 years'),
('Bachelor of Secondary Education', 'BSED', 'college', '4-year program preparing future secondary school teachers with various specializations.', '4 years');

-- Sample Gallery Data
INSERT INTO gallery (title, category, description) VALUES
('Campus Grounds', 'campus', 'Beautiful and well-maintained campus grounds of SMCC'),
('Library', 'facilities', 'Modern library with extensive collection of books and digital resources'),
('Computer Laboratory', 'facilities', 'State-of-the-art computer lab for technology students'),
('Sports Complex', 'campus', 'Complete sports facilities for various athletic activities'),
('Chapel', 'campus', 'Sacred space for prayer and spiritual formation'),
('Science Laboratory', 'facilities', 'Well-equipped laboratory for science experiments'),
('Covered Court', 'facilities', 'Multi-purpose indoor facility for sports and events'),
('Canteen', 'facilities', 'Clean and hygienic food service area'),
('Garden Area', 'campus', 'Peaceful garden space for relaxation and study');

-- ===================================
-- Views for Easy Data Retrieval
-- ===================================

-- View for recent news
CREATE VIEW recent_news AS
SELECT * FROM news 
ORDER BY date DESC 
LIMIT 10;

-- View for news statistics
CREATE VIEW news_stats AS
SELECT 
    category,
    COUNT(*) as total_news,
    MAX(date) as latest_news_date
FROM news
GROUP BY category;

-- View for monthly analytics
CREATE VIEW monthly_analytics AS
SELECT 
    DATE_FORMAT(visit_date, '%Y-%m') as month,
    COUNT(*) as total_visits,
    COUNT(DISTINCT visitor_ip) as unique_visitors
FROM analytics
GROUP BY month
ORDER BY month DESC;

-- ===================================
-- Stored Procedures
-- ===================================

-- Procedure to get news by category
DELIMITER //
CREATE PROCEDURE GetNewsByCategory(IN cat VARCHAR(50))
BEGIN
    SELECT * FROM news 
    WHERE category = cat 
    ORDER BY date DESC;
END //
DELIMITER ;

-- Procedure to add visitor analytics
DELIMITER //
CREATE PROCEDURE AddVisitorAnalytics(
    IN p_page_url VARCHAR(255),
    IN p_visitor_ip VARCHAR(45),
    IN p_user_agent TEXT
)
BEGIN
    INSERT INTO analytics (page_url, visitor_ip, user_agent, visit_date, visit_time)
    VALUES (p_page_url, p_visitor_ip, p_user_agent, CURDATE(), CURTIME());
END //
DELIMITER ;

-- ===================================
-- Triggers
-- ===================================

-- Trigger to update timestamp on news update
DELIMITER //
CREATE TRIGGER before_news_update 
BEFORE UPDATE ON news
FOR EACH ROW
BEGIN
    SET NEW.updated_at = CURRENT_TIMESTAMP;
END //
DELIMITER ;

-- ===================================
-- Grant Privileges (for production)
-- ===================================
-- GRANT ALL PRIVILEGES ON marianconnect_db.* TO 'smcc_user'@'localhost' IDENTIFIED BY 'secure_password';
-- FLUSH PRIVILEGES;

-- ===================================
-- Indexes for Performance
-- ===================================
CREATE INDEX idx_news_search ON news(title, content(100));
CREATE INDEX idx_admin_username ON admin_users(username);
CREATE INDEX idx_analytics_ip ON analytics(visitor_ip);

-- ===================================
-- Database Optimization
-- ===================================
OPTIMIZE TABLE news;
OPTIMIZE TABLE admin_users;
OPTIMIZE TABLE gallery;
OPTIMIZE TABLE programs;
OPTIMIZE TABLE contact_messages;
OPTIMIZE TABLE analytics;

-- Success message
SELECT 'MARIANCONNECT Database created successfully!' AS status;
