<?php declare(strict_types=1);

namespace App\Handler;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserHandler implements RequestHandlerInterface {
    public function __construct() {}

    public function handle(ServerRequestInterface $request): ResponseInterface {
      return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'success' => true, 'data' => __FILE__ ] ) );
    }
}