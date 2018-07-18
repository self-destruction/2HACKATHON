<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Car;
use Doctrine\DBAL\Connection;
use App\Service\CarService;

class CarController extends BaseController
{
    private $carService;
    
    public function __construct(App $app, Connection $conn)
    {
        parent::__construct($app);
        $this->carService = new CarService($conn);
        $app->post('', [$this, 'saveCar']);
    }

    public function saveCar(Request $request, Response $response) {
        try {
            //лишние заголовки - невалид
            $data = json_decode($request->getBody(), true);

            if (!is_numeric($data['id'])) {
                throw new \LogicException(__CLASS__ . "saveCar() id is not integer");
            }
            if (!is_string($data['model'])) {
                throw new \LogicException(__CLASS__ . "saveCar() model is not string");
            }
            if (!is_numeric($data['horsepower'])) {
                throw new \LogicException(__CLASS__ . "saveCar() horsepower is not integer");
            }
            if (!is_numeric($data['ownerId'])) {
                throw new \LogicException(__CLASS__ . "saveCar() ownerId is not integer");
            }

            if ((int)$data['horsepower'] <= 0) {
                throw new \LogicException(__CLASS__ . "saveCar() horsepower <= 0");
            }

            $model = $this->modelSplit((string)$data['model']);

            $car = new Car(
                (int)$data['id'], 
                (string)$model['vendor'],
                (string)$model['model'],
                (int)$data['horsepower'],
                (int)$data['ownerId'] 
            );

            $this->carService->saveCarModel($car);

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

    public function modelSplit($fullModel) {
        $posDefis = stripos ($fullModel, "-");
        if (!(($posDefis > 0) && ($posDefis < (strlen($fullModel)-1)))) {
            throw new \LogicException('Wrong format of model!');
        }
        $vender = substr ($fullModel, 0, $posDefis);
        $model = substr ($fullModel, $posDefis+1, strlen($fullModel)-1-strlen($vender));

        return [
            'vendor' => $vender,
            'model' => $model
        ];
    }
}