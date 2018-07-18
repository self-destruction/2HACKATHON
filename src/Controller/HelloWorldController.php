<?php

namespace App\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class HelloWorldController extends BaseController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
        $app->get('/[{name}]', [$this, 'sayHello']);
    }

    public function sayHello(Request $request, Response $response, $args) {
        $name = empty($args['name']) ? 'Unnamed' : $args['name'];

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withJson([
                'name' => $name
            ], 201);
    }
}