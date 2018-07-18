<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\{Car, Person};
use Doctrine\DBAL\Connection;
use App\Service\PersonwithcarsService;

class PersonwithcarsController extends BaseController
{
    private $personwithcarsService;
    
    public function __construct(App $app, Connection $conn)
    {
        parent::__construct($app);
        $this->personwithcarsService = new PersonwithcarsService($conn);
        $app->get('', [$this, 'getPersonwithcars']);
    }

    public function getPersonwithcars(Request $request, Response $response, $args) {
        try {
            $personid = empty($_GET['personid']) ? null : $_GET['personid'];

            if (!is_numeric($personid)) {
                throw new \LogicException("personid is not numeric");
            }

            $person = $this->personwithcarsService->loadPersonModel($personid);

            $cars = $this->personwithcarsService->loadCarsArray($person);

            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->withJson([
                    'id' => $person->getIdModel(),
                    'name' => $person->getNameModel(),
                    'birthdate' => date("d.m.Y", strtotime($person->getBirthdatelModel())),
                    'cars' => $cars
                ], 200);

        } catch(\LogicException $exception) {
            error_log($exception->getMessage());
            $code = 400;
            if ($exception->getCode() === 404) {
                $code = 404;
            }
            return $response
                ->withStatus($code)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}