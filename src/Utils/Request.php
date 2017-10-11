<?php

namespace LasseRafn\DKS\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use LasseRafn\DKS\Exceptions\DKSRequestException;
use LasseRafn\DKS\Exceptions\DKSServerException;

class Request
{
	public $curl;

	protected $baseUri     = 'https://iks.dks.dk/backend/api/v1/';
	protected $testBaseUri = 'https://demo.dks.dk/iks/backend/api/v1/';

	public function __construct( $token = null, $clientConfig = [], $testing = false ) {
		$headers                 = [];

		if ( $token !== null ) {
			$headers['Authorization'] = "WebBruger {$token}";
			$headers['Content-Type'] = 'application/json';
		}

		$this->curl = new Client( array_merge_recursive( [
			'base_uri' => $testing ? $this->testBaseUri : $this->baseUri,
			'headers'  => $headers,
		], $clientConfig ) );
	}

	public function post( $endpoint, $data, $isJson = true ) {
		try {
			$response = $this->curl->post( $endpoint, $data )->getBody()->getContents();

			if ( $isJson ) {
				$response = json_decode( $response );
			}

			return $response;
		} catch ( ClientException $exception ) {
			throw new DKSRequestException( $exception );
		} catch ( ServerException $exception ) {
			throw new DKSServerException( $exception );
		}
	}

	public function get( $endpoint, $data = [], $isJson = true ) {
		try {
			$response = $this->curl->get( $endpoint, $data )->getBody()->getContents();

			if ( $isJson ) {
				$response = json_decode( $response );
			}

			return $response;
		} catch ( ClientException $exception ) {
			throw new DKSRequestException( $exception );
		} catch ( ServerException $exception ) {
			throw new DKSServerException( $exception );
		}
	}
}
