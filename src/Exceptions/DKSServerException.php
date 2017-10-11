<?php

namespace LasseRafn\DKS\Exceptions;

use GuzzleHttp\Exception\ServerException;

class DKSServerException extends ServerException
{
	public $validationErrors = [];

	public function __construct( ServerException $clientException ) {
		$message = $clientException->getMessage();

		if ( $clientException->hasResponse() ) {
			$messageResponse = json_decode( $clientException->getResponse()
			                                                ->getBody()
			                                                ->getContents() );

			$message = '';

			if ( isset( $messageResponse->Message ) ) {
				$message = "{$messageResponse->Message}";
			}

			if ( isset( $messageResponse->ModelState ) ) {
				foreach ( $messageResponse->ModelState as $item => $value ) {
					$this->validationErrors[ $item ] = [];
					foreach ( $value as $error ) {
						$this->validationErrors[ $item ][] = $error;
					}
				}
			}
		}

		$request        = $clientException->getRequest();
		$response       = $clientException->getResponse();
		$previous       = $clientException->getPrevious();
		$handlerContext = $clientException->getHandlerContext();

		parent::__construct( $message, $request, $response, $previous, $handlerContext );
	}
}
