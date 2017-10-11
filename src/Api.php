<?php

namespace LasseRafn\DKS;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use LasseRafn\DKS\Builders\ContactBuilder;
use LasseRafn\DKS\Builders\CreditnoteBuilder;
use LasseRafn\DKS\Builders\InvoiceBuilder;
use LasseRafn\DKS\Builders\ProductBuilder;
use LasseRafn\DKS\Exceptions\DineroRequestException;
use LasseRafn\DKS\Exceptions\DineroServerException;
use LasseRafn\DKS\Requests\ContactRequestBuilder;
use LasseRafn\DKS\Requests\CreditnoteRequestBuilder;
use LasseRafn\DKS\Requests\InvoiceRequestBuilder;
use LasseRafn\DKS\Requests\ProductRequestBuilder;
use LasseRafn\DKS\Utils\Request;

class Api
{
    protected $request;

    private $clientId;
    private $clientSecret;

    private $authToken;
    private $org;

    public function __construct($clientId, $clientSecret, $token = null, $org = null, $clientConfig = [])
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->authToken = $token;
        $this->org = $org;

        $this->request = new Request($clientId, $clientSecret, $this->authToken, $this->org, $clientConfig);
    }

    public function setAuth($token, $org = null)
    {
        $this->authToken = $token;
        $this->org = $org;

        $this->request = new Request($this->clientId, $this->clientSecret, $this->authToken, $this->org);
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function getAuthUrl()
    {
        return $this->request->getAuthUrl();
    }

    public function getOrgId()
    {
        return $this->org;
    }

    public function auth($apiKey, $orgId = null)
    {
        try {
            $response = json_decode($this->request->curl->post($this->request->getAuthUrl(), [
                'form_params' => [
                    'grant_type' => 'password',
                    'scope'      => 'read write',
                    'username'   => $apiKey,
                    'password'   => $apiKey,
                ],
            ])->getBody()->getContents());

            $this->setAuth($response->access_token, $orgId);

            return $response;
        } catch (ClientException $exception) {
            throw new DineroRequestException($exception);
        } catch (ServerException $exception) {
            throw new DineroServerException($exception);
        }
    }

    public function contacts()
    {
        return new ContactRequestBuilder(new ContactBuilder($this->request));
    }

    public function invoices()
    {
        return new InvoiceRequestBuilder(new InvoiceBuilder($this->request));
    }

    public function products()
    {
        return new ProductRequestBuilder(new ProductBuilder($this->request));
    }

    public function creditnotes()
    {
        return new CreditnoteRequestBuilder(new CreditnoteBuilder($this->request));
    }
}
