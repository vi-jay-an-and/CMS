<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\Analytics\ParentEngagementService;

class AnalyticsController extends Controller
{
    public function __construct(private ParentEngagementService $parentEngagement)
    {
    }

    public function parentEngagement(Request $request): Response
    {
        $parentId = (int) $request->query('parent_id', 0);
        if (!$parentId) {
            return $this->error('parent_id is required', 422);
        }

        $score = $this->parentEngagement->engagementScore($parentId);

        return $this->ok(['data' => $score]);
    }
}
