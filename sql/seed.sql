INSERT INTO parents (name, email, phone, address) VALUES
('Anita Sharma', 'anita.sharma@example.com', '+911234567890', 'Mumbai, India'),
('Rahul Verma', 'rahul.verma@example.com', '+911198765432', 'Delhi, India');

INSERT INTO students (name, program, batch, attendance_percentage) VALUES
('Riya Sharma', 'B.Tech CSE', '2025', 88.50),
('Aarav Verma', 'MBA', '2024', 92.30);

INSERT INTO parent_student_link (parent_id, student_id, relationship) VALUES
(1, 1, 'Mother'),
(2, 2, 'Father');

INSERT INTO parent_feedback (parent_id, student_id, message, response) VALUES
(1, 1, 'Appreciate the timely updates on attendance.', 'Thank you for the feedback!'),
(2, 2, 'Concerned about placement preparation schedule.', NULL);

INSERT INTO notifications (title, message, target_role) VALUES
('PTM Schedule', 'Parent-teacher meeting scheduled for next Friday.', 'parent'),
('Exam Results', 'Mid-term results published on the portal.', 'parent'),
('Career Fair', 'Mega placement drive registrations open now.', 'all');

INSERT INTO attendance_history (student_id, attendance_date, attendance_percentage) VALUES
(1, '2023-08-01', 90.0),
(1, '2023-08-08', 88.0),
(1, '2023-08-15', 87.5),
(2, '2023-08-01', 95.0),
(2, '2023-08-08', 93.0),
(2, '2023-08-15', 92.5);

INSERT INTO student_performance_summary (student_id, exam_type, average_score, last_exam_score, attendance_percentage) VALUES
(1, 'Mid Term', 85.0, 88.0, 88.5),
(1, 'Quiz', 90.0, 92.0, 88.5),
(2, 'Mid Term', 88.0, 90.0, 92.3),
(2, 'Quiz', 91.0, 94.0, 92.3);

INSERT INTO placement_applications (student_id, company_name, role, status) VALUES
(1, 'TechWave', 'Software Engineer', 'interview'),
(1, 'DataSphere', 'Data Analyst', 'shortlisted'),
(2, 'FinCorp', 'Business Analyst', 'offer');
