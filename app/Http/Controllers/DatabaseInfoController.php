<?php

namespace App\Http\Controllers;

use App\Services\DatabaseOptimizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DatabaseInfoController extends Controller
{
    /**
     * Display database configuration information.
     */
    public function index(): JsonResponse
    {
        $optimizer = new DatabaseOptimizationService();
        $info = $optimizer->getDatabaseInfo();
        
        return response()->json([
            'database_info' => $info,
            'mysql_ready' => $this->checkMySQLReady($info),
            'recommendations' => $this->buildRecommendations($info),
        ]);
    }

    /**
     * Apply database optimizations.
     */
    public function store(Request $request): JsonResponse
    {
        $optimizer = new DatabaseOptimizationService();
        $optimizer->optimize();

        return response()->json([
            'message' => 'Database optimizations applied',
            'database_info' => $optimizer->getDatabaseInfo(),
        ]);
    }

    /**
     * Check if MySQL is properly configured.
     */
    protected function checkMySQLReady(array $info): bool
    {
        return $info['driver'] === 'mysql' 
            && $info['japanese_support'] === true
            && isset($info['charset']) 
            && $info['charset'] === 'utf8mb4';
    }

    /**
     * Get configuration recommendations.
     */
    protected function buildRecommendations(array $info): array
    {
        $recommendations = [];

        if ($info['driver'] !== 'mysql') {
            $recommendations[] = [
                'type' => 'warning',
                'message' => 'Database driver is not MySQL. Current driver: ' . $info['driver'],
                'action' => 'Update DB_CONNECTION in .env to "mysql"'
            ];
        }

        if (isset($info['charset']) && $info['charset'] !== 'utf8mb4') {
            $recommendations[] = [
                'type' => 'error',
                'message' => 'Database charset is not utf8mb4. Current: ' . $info['charset'],
                'action' => 'Run migration to convert tables to utf8mb4'
            ];
        }

        if (isset($info['collation']) && $info['collation'] !== 'utf8mb4_unicode_ci') {
            $recommendations[] = [
                'type' => 'warning',
                'message' => 'Database collation is not utf8mb4_unicode_ci. Current: ' . $info['collation'],
                'action' => 'Consider updating collation for better Japanese character sorting'
            ];
        }

        if (!$info['japanese_support']) {
            $recommendations[] = [
                'type' => 'error',
                'message' => 'Japanese character support test failed',
                'action' => 'Check database charset and collation settings'
            ];
        }

        if (empty($recommendations)) {
            $recommendations[] = [
                'type' => 'success',
                'message' => 'MySQL is properly configured for Japanese characters!',
                'action' => 'No action needed'
            ];
        }

        return $recommendations;
    }
}