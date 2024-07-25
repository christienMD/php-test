<?php

namespace Mdchristien\PhpTest\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RecipeController
{
    public function list(Request $request, Response $response): Response
    {
        
        $response->getBody()->write("List recipes");
        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        
        $response->getBody()->write("Create recipe");
        return $response;
    }

    public function get(Request $request, Response $response, array $args): Response
    {
        
        $response->getBody()->write("Get recipe " . $args['id']);
        return $response;
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        
        $response->getBody()->write("Update recipe " . $args['id']);
        return $response;
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        
        $response->getBody()->write("Delete recipe " . $args['id']);
        return $response;
    }

    public function rate(Request $request, Response $response, array $args): Response
    {
        
        $response->getBody()->write("Rate recipe " . $args['id']);
        return $response;
    }

    public function search(Request $request, Response $response): Response
    {
        
        $response->getBody()->write("Search recipes");
        return $response;
    }
}
