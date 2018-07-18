<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Person;
use Doctrine\DBAL\Connection;
use App\Service\PersonService;

class PersonController extends BaseController
{
    private $personService;
    // private const PERSON_PURCHASE_SCHEMA = __DIR__ . '/resources/jsonSchema/person.json';

    public function __construct(App $app, Connection $conn)
    {
        parent::__construct($app);
        $this->personService = new PersonService($conn);
        $app->post('', [$this, 'savePerson']);
    }

    public function savePerson(Request $request, Response $response) {
        try {
            $data = json_decode($request->getBody(), true);

            //лишние заголовки

            if (!is_numeric($data['id'])) {
                throw new \LogicException(__CLASS__ . " savePerson() id is not integer");
            }
            if (!is_string($data['name'])) {
                throw new \LogicException(__CLASS__ . " savePerson() name is not string");
            } 
            if (!is_string($data['birthdate'])) {
                throw new \LogicException(__CLASS__ . " savePerson() birthdate is not string");
            }
            if (date(strtotime((string)$data['birthdate']) >= date(strtotime("now")))) {
                throw new \LogicException('birthdate not in past!');
            }
            if (!$this->proverkaFormataDati((string)$data['birthdate'])) {
                throw new \LogicException('Uncorrect data format!');
            }

            $person = new Person(
                (int)$data['id'], 
                (string)$data['name'],
                (string)date('Y-m-d', strtotime((string)$data['birthdate']))
            );

            $this->personService->savePersonModel($person);

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

    function proverkaFormataDati($data){
        $pattern = "/^([0-9]{2}).([0-9]{2}).([0-9]{4})$/"; // Основной 2013-10-22
        if ( preg_match($pattern, $data, $razdeli) ) :
        if ( checkdate($razdeli[2],$razdeli[1],$razdeli[3]) )
        return true;
        else
        return false;
        else :
        return false;
        endif;
    }
}