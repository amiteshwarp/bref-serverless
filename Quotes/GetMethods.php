<?php

namespace Entrata\ResidentInsureQuote\Quotes;

use Aws\DynamoDb\Exception\DynamoDbException;
use DateTime;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class GetMethods {

	public function get( ServerRequestInterface $objRequest ) : Response {
		return match ( ( string ) $objRequest->getAttribute( 'data' ) ) {
			// 'create_table' => self::getDate( $objRequest->getMethod() ),
			// 'feed_data' => self::getTime( $objRequest->getMethod() ),
			'search' => self::searchData(),
			default => ( new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'method' => $objRequest->getMethod(), 'response' => $objRequest->getAttribute( 'data' ) . ' not defined', 'requested' => __CLASS__ ] ) ) )
		};
	}

	private static function createTable() : Response {
		$params = [
			'TableName'             => 'Movies',
			'KeySchema'             => [
				[
					'AttributeName' => 'year',
					'KeyType'       => 'HASH'  //Partition key
				],
				[
					'AttributeName' => 'title',
					'KeyType'       => 'RANGE'  //Sort key
				]
			],
			'AttributeDefinitions'  => [
				[
					'AttributeName' => 'year',
					'AttributeType' => 'N'
				],
				[
					'AttributeName' => 'title',
					'AttributeType' => 'S'
				],

			],
			'ProvisionedThroughput' => [
				'ReadCapacityUnits'  => 10,
				'WriteCapacityUnits' => 10
			]
		];

		try {
			$result = ( self::connectDynamoDb() )->createTable( $params );

			return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'response' => 'Created table.  Status: ' . $result['TableDescription']['TableStatus'], 'requested' => __CLASS__ ] ) );
		} catch( DynamoDbException $e ) {
			return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'response' => $e->getMessage(), 'requested' => __CLASS__ ] ) );
		}
	}

	private function connectDynamoDb() {
		return ( new \Aws\Sdk( [
			'endpoint' => 'http://localhost:8000',
			'region'   => 'us-west-2',
			'version'  => 'latest'
		] ) )->createDynamoDb();
	}

	private function feedData() {
		$marshaler = new \Aws\DynamoDb\Marshaler();
		$movies    = json_decode( file_get_contents( '/srv/www/vhosts/bref-serverless/Quotes/moviedata.json' ), true );

		foreach( $movies as $movie ) {
			$year  = $movie['year'];
			$title = $movie['title'];
			$info  = $movie['info'];

			$json = json_encode( [
				'year'  => $year,
				'title' => $title,
				'info'  => $info
			] );

			$params = [
				'TableName' => 'Movies',
				'Item'      => $marshaler->marshalJson( $json )
			];

			try {
				$result = ( self::connectDynamoDb() )->putItem( $params );
				echo "Added movie: " . $movie['year'] . " " . $movie['title'] . "\n";
			} catch( DynamoDbException $e ) {
				echo "Unable to add movie:\n";
				echo $e->getMessage() . "\n";
				break;
			}

		}
	}

	private function searchData() {

		$marshaler = new \Aws\DynamoDb\Marshaler();

		$year  = 2004;
		$title = 'Alfie';

		$params = [
			'TableName' => 'Movies',
			'Key'       => $marshaler->marshalJson( json_encode( [ 'year' => $year, 'title' => $title ] ) )
		];

		try {
			$result = ( self::connectDynamoDb() )->getItem( $params );

			return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'response' => $result['Item'] ] ) );

		} catch( DynamoDbException $e ) {
			return new Response( 200, [ 'Content-Type' => 'application/json' ], json_encode( [ 'response' => $e->getMessage(), 'requested' => __CLASS__ ] ) );
		}
	}

}