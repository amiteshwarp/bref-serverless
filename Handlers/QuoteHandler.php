<?php declare( strict_types=1 );

namespace Entrata\ResidentInsureQuote\Handlers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Entrata\ResidentInsureQuote\Quotes\GetMethods;
use Entrata\ResidentInsureQuote\Quotes\PostMethods;

class QuoteHandler implements RequestHandlerInterface {

	private GetMethods $getMethods;
	private PostMethods $postMethods;

	public function __construct() {
		$this->getMethods  = new GetMethods();
		$this->postMethods = new PostMethods();
	}

	public function handle( ServerRequestInterface $objRequest ) : ResponseInterface {
		return match ( $objRequest->getMethod() ) {
			"GET" => ( $this->getMethods->get( $objRequest ) ),
			"POST" => ( $this->postMethods->post( $objRequest ) ),
			default => new Response( 422, [], 'Error Occurred: Unknown method: ' . $objRequest->getMethod() ),
		};
	}
}