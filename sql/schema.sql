CREATE TABLE parents (
    parent_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    program VARCHAR(120) NOT NULL,
    batch VARCHAR(20) NOT NULL,
    attendance_percentage DECIMAL(5,2) DEFAULT 0.00
);

CREATE TABLE parent_student_link (
    link_id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NOT NULL,
    student_id INT NOT NULL,
    relationship VARCHAR(50) NOT NULL,
    CONSTRAINT fk_parent_link_parent FOREIGN KEY (parent_id) REFERENCES parents(parent_id),
    CONSTRAINT fk_parent_link_student FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE parent_feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    parent_id INT NOT NULL,
    student_id INT NOT NULL,
    message TEXT NOT NULL,
    response TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_feedback_parent FOREIGN KEY (parent_id) REFERENCES parents(parent_id),
    CONSTRAINT fk_feedback_student FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE notifications (
    notif_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    target_role ENUM('admin','hod','teaching','non_teaching','student','parent','company','alumni','all') DEFAULT 'all',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE attendance_history (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    attendance_percentage DECIMAL(5,2) NOT NULL,
    CONSTRAINT fk_attendance_student FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE student_performance_summary (
    summary_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_type VARCHAR(100) NOT NULL,
    average_score DECIMAL(5,2) NOT NULL,
    last_exam_score DECIMAL(5,2) NOT NULL,
    attendance_percentage DECIMAL(5,2) NOT NULL,
    CONSTRAINT fk_performance_student FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE placement_applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    status ENUM('applied','shortlisted','interview','offer','rejected') DEFAULT 'applied',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_placement_student FOREIGN KEY (student_id) REFERENCES students(student_id)
);
