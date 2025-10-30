<?php

namespace App\Repositories;

use PDO;

class NotificationRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function latestForRole(string $role, int $limit = 10): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT notif_id, title, message, created_at
             FROM notifications
             WHERE target_role = :role OR target_role = "all"
             ORDER BY created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue('role', $role);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
