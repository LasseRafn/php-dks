<?php

namespace LasseRafn\DKS\Exceptions;

use GuzzleHttp\Exception\ClientException;

class DKSRequestException extends ClientException
{
    public $validationErrors = [];

    public function __construct(ClientException $clientException)
    {
        $message = $clientException->getMessage();

        if ($clientException->hasResponse()) {
            $messageResponse = json_decode($clientException->getResponse()
                                                            ->getBody()
                                                            ->getContents());

            $message = '';

            if (isset($messageResponse->Message)) {
                $message = "{$messageResponse->Message}:";
            }
        }

        $request = $clientException->getRequest();
        $response = $clientException->getResponse();
        $previous = $clientException->getPrevious();
        $handlerContext = $clientException->getHandlerContext();

        parent::__construct($message, $request, $response, $previous, $handlerContext);
    }
}
