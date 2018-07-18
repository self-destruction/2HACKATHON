<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\DBAL\Connection;
use App\Service\ClearService;

class ClearController extends BaseController
{
    private $clearService;
    
    public function __construct(App $app, Connection $conn)
    {
        parent::__construct($app);
        $this->clearService = new ClearService($conn);
        $app->get('', [$this, 'clearController']);
    }

    public function clearController(Request $request, Response $response) {
        try {
            $this->clearService->clearDB();

            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json');

        } catch(\LogicException $exception) {
            error_log($exception->getMessage());
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}