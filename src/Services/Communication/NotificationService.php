<?php

namespace App\Services\Communication;

use App\Repositories\NotificationRepository;

class NotificationService
{
    public function __construct(private NotificationRepository $notifications)
    {
    }

    public function feedForParent(): array
    {
        return $this->notifications->latestForRole('parent');
    }
}
