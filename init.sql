
-- Create database and tables
CREATE DATABASE IF NOT EXISTS ulab_clubs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ulab_clubs;

-- Students table
CREATE TABLE IF NOT EXISTS students (
  student_id VARCHAR(20) PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Clubs table
CREATE TABLE IF NOT EXISTS clubs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  description TEXT
) ENGINE=InnoDB;

-- Memberships table (one membership per student)
CREATE TABLE IF NOT EXISTS memberships (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(20) NOT NULL,
  club_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_member_student FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_member_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT uc_member UNIQUE (student_id)
) ENGINE=InnoDB;

-- Seed a few clubs
INSERT IGNORE INTO clubs (name, description) VALUES
('Adventure Club', 'Explore the outdoors and engage in adventurous activities.'),
('Art & Photography Club', 'A creative space for art lovers and photographers.'),
('Business Club', 'For aspiring business leaders and entrepreneurs.'),
('Computer Society', 'For programming, AI/ML, and tech enthusiasts.'),
('Debating Club', 'Practice structured and intellectual debates.'),
('Digital Marketing Club', 'Hands-on campaigns, SEO/SEM, and analytics.'),
('Electronics Club', 'Hardware builds, robotics, and embedded systems.'),
('Field Sports Club', 'Football, cricket, and outdoor team sports.'),
('Film Club', 'Watch, analyze, and produce short films.'),
('History Club', 'Explore and discuss history and historical analysis.'),
('Indoor Games Club', 'Chess, carrom, and more.');
