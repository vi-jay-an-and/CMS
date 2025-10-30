<?php

namespace App\Services\Analytics;

use App\Repositories\ParentRepository;
use App\Repositories\StudentRepository;

class ParentEngagementService
{
    public function __construct(
        private ParentRepository $parents,
        private StudentRepository $students,
    ) {
    }

    public function engagementScore(int $parentId): array
    {
        $parent = $this->parents->find($parentId);
        if (!$parent) {
            return ['score' => 0, 'status' => 'inactive'];
        }

        $feedbackCount = count($parent['feedback']);
        $studentCount = count($parent['students']);

        $scores = [];
        foreach ($parent['students'] as $student) {
            $trend = $this->students->attendanceTrend((int) $student['student_id'], 10);
            $latest = $trend[0]['attendance_percentage'] ?? 0;
            $scores[] = (float) $latest;
        }

        $attendanceAverage = empty($scores) ? 0.0 : array_sum($scores) / count($scores);

        $score = min(100, $attendanceAverage + ($feedbackCount * 5) + ($studentCount * 10));
        $status = $score >= 80 ? 'high' : ($score >= 50 ? 'medium' : 'low');

        return [
            'parent_id' => $parentId,
            'score' => round($score, 2),
            'status' => $status,
            'feedback_count' => $feedbackCount,
            'student_count' => $studentCount,
            'attendance_average' => round($attendanceAverage, 2),
        ];
    }
}
