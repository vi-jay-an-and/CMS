<?php

namespace App\Repositories;

use PDO;

class StudentRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function attendanceTrend(int $studentId, int $limit = 30): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT attendance_date, attendance_percentage
             FROM attendance_history
             WHERE student_id = :student_id
             ORDER BY attendance_date DESC
             LIMIT :limit'
        );
        $stmt->bindValue('student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function performanceSummary(int $studentId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT exam_type, average_score, last_exam_score, attendance_percentage
             FROM student_performance_summary
             WHERE student_id = :student_id'
        );
        $stmt->execute(['student_id' => $studentId]);

        return $stmt->fetchAll();
    }

    public function placementActivities(int $studentId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT company_name, role, status, updated_at
             FROM placement_applications
             WHERE student_id = :student_id
             ORDER BY updated_at DESC'
        );
        $stmt->execute(['student_id' => $studentId]);

        return $stmt->fetchAll();
    }
}
