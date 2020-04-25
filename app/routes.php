<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;

return function (App $app) {
    $app->get('/', function (RequestInterface $request, ResponseInterface $response, $args) {
        $response->getBody()->write("Hello World");
        return $response;
    });

    $app->get('/api/server/', function (Request $request, Response $response, $args) {

    $sql = "Select * from servers";

        try {

            $db = new db();

            $db = $db->connect();

            $stmt = $db->query($sql);

            $server = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            $db = null;

            echo json_encode ($server);

        }
            catch(PDOException $e) {
                echo '{"error" : {"text" : ' . $e->getMessage(). '}';

            }
    
    });


    $container = $app->getContainer();

    $app->group('', function (RouteCollectorProxy $view)
    {
        $view->get('/example/{name}', function($request, $response, $args) {
            $name = $args['name'];

            return $this->get('view')->render($response, 'example.twig', compact('name'));
        });

        $view->get('/views/{name}', function ($request, $response, $args) {
            $view = 'example.twig';
            $name = $args['name'];

            return $this->get('view')->render($response, $view, compact('name'));
        });

    })->add($container->get('viewMiddleware'));
};
