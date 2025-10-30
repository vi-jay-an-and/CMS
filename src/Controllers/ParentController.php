<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Repositories\ParentRepository;
use App\Repositories\StudentRepository;
use App\Services\Analytics\ParentEngagementService;
use App\Services\Communication\NotificationService;

class ParentController extends Controller
{
    public function __construct(
        private ParentRepository $parents,
        private StudentRepository $students,
        private ParentEngagementService $analytics,
        private NotificationService $notifications
    ) {
    }

    public function index(): Response
    {
        $parents = $this->parents->all();

        return $this->ok(['data' => $parents]);
    }

    public function show(array $params): Response
    {
        $parentId = (int) ($params['id'] ?? 0);
        $parent = $this->parents->find($parentId);

        if (!$parent) {
            return $this->error('Parent not found', 404);
        }

        $engagement = $this->analytics->engagementScore($parentId);
        $notifications = $this->notifications->feedForParent();

        return $this->ok([
            'data' => $parent,
            'analytics' => $engagement,
            'notifications' => $notifications,
        ]);
    }

    public function feedback(Request $request, array $params): Response
    {
        $parentId = (int) ($params['id'] ?? 0);
        $studentId = (int) $request->input('student_id');
        $message = (string) $request->input('message');

        if (!$parentId || !$studentId || $message === '') {
            return $this->error('Invalid feedback payload', 422);
        }

        $feedback = $this->parents->storeFeedback($parentId, $studentId, $message);

        return $this->created(['data' => $feedback]);
    }

    public function studentSnapshot(array $params): Response
    {
        $studentId = (int) ($params['studentId'] ?? 0);
        if (!$studentId) {
            return $this->error('Student ID is required', 422);
        }

        $trend = $this->students->attendanceTrend($studentId, 15);
        $summary = $this->students->performanceSummary($studentId);
        $placements = $this->students->placementActivities($studentId);

        return $this->ok([
            'attendance_trend' => $trend,
            'performance_summary' => $summary,
            'placement_activities' => $placements,
        ]);
    }
}
