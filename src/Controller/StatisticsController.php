<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Connection;
use App\Service\StatisticsService;

class StatisticsController extends BaseController
{
    private $clearService;
    
    public function __construct(App $app, Connection $conn)
    {
        parent::__construct($app);
        $this->statisticsService = new StatisticsService($conn);
        $app->get('', [$this, 'getStatistics']);
    }

    public function getStatistics(Request $request, Response $response) {
        try {
            $stats = $this->statisticsService->getStats();

            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withJson([
                    'personcount' => $stats['personcount'],
                    'carcount' => $stats['carcount'],
                    'uniquevendorcount' => $stats['uniquevendorcount']
                ]);

        } catch(\LogicException $exception) {
            error_log($exception->getMessage());
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}