<?php

namespace Entrata\ResidentInsureQuote\Quotes;

use DateTime;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class PostMethods {

	public function post( ServerRequestInterface $objRequest ) : Response {
		return match ( ( string ) $objRequest->getAttribute( 'data' ) ) {
			'date' 	=> self::getDate( $objRequest->getMethod() ),
			'time' 	=> self::getTime( $objRequest->getMethod() ),
			'all' 	=> self::getDateTime( $objRequest->getMethod() ),
			default => ( new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'method' => $objRequest->getMethod(), 'response' => $objRequest->getAttribute( 'data' ) . ' not defined', 'requested' => __CLASS__ ] ) ) )
		};
	}

	private static function getDate( $strRequestMethod ) : Response {
		$objDateTime = new DateTime( 'NOW' );

		return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'method' => $strRequestMethod, 'response' => $objDateTime->format( 'Y-m-d' ), 'requested' => __CLASS__ ] ) );
	}

	private static function getTime( $strRequestMethod ) : Response {
		$objDateTime = new DateTime( 'NOW' );

		return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'method' => $strRequestMethod, 'response' => $objDateTime->format( '\TH:i:s.u' ), 'requested' => __CLASS__ ] ) );
	}

	private static function getDateTime( $strRequestMethod ) : Response {
		$objDateTime = new DateTime( 'NOW' );

		return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'method' => $strRequestMethod, 'response' => $objDateTime->format( 'Y-m-d\TH:i:s.u' ), 'requested' => __CLASS__ ] ) );
	}
}