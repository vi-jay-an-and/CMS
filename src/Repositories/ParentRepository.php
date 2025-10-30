<?php

namespace App\Repositories;

use PDO;

class ParentRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM parents ORDER BY name');
        return $stmt->fetchAll();
    }

    public function find(int $parentId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM parents WHERE parent_id = :id');
        $stmt->execute(['id' => $parentId]);
        $parent = $stmt->fetch();

        if (!$parent) {
            return null;
        }

        $parent['students'] = $this->linkedStudents($parentId);
        $parent['feedback'] = $this->recentFeedback($parentId);

        return $parent;
    }

    public function linkedStudents(int $parentId): array
    {
        $sql = 'SELECT s.student_id, s.name, s.program, s.batch, link.relationship, s.attendance_percentage
                FROM parent_student_link link
                INNER JOIN students s ON s.student_id = link.student_id
                WHERE link.parent_id = :parent_id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['parent_id' => $parentId]);

        return $stmt->fetchAll();
    }

    public function recentFeedback(int $parentId, int $limit = 10): array
    {
        $sql = 'SELECT feedback_id, student_id, message, response, created_at
                FROM parent_feedback
                WHERE parent_id = :parent_id
                ORDER BY created_at DESC
                LIMIT :limit';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('parent_id', $parentId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function storeFeedback(int $parentId, int $studentId, string $message): array
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO parent_feedback (parent_id, student_id, message) VALUES (:parent_id, :student_id, :message)'
        );
        $stmt->execute([
            'parent_id' => $parentId,
            'student_id' => $studentId,
            'message' => $message,
        ]);

        $feedbackId = (int) $this->pdo->lastInsertId();

        return [
            'feedback_id' => $feedbackId,
            'parent_id' => $parentId,
            'student_id' => $studentId,
            'message' => $message,
        ];
    }
}
