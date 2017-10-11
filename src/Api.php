<?php

namespace LasseRafn\DKS;

use LasseRafn\DKS\Models\CaseItem;
use LasseRafn\DKS\Utils\Request;

class Api
{
	/** @var Request */
	protected $request;

	private $authToken;
	private $clientConfig;
	private $test = false;

	public function __construct( $token = null, $clientConfig = [] ) {
		$this->setAuthToken( $token );
		$this->clientConfig = $clientConfig;

		$this->auth();
	}

	public function testMode() {
		$this->test = true;
		$this->auth();

		return $this;
	}

	public function productionMode() {
		$this->test = false;
		$this->auth();

		return $this;
	}

	public function testConnection() {
		return $this->request->get( 'test' );
	}

	public function requestToken( $customerNumber, $username, $password ) {
		$token = $this->request->get( 'request-token', [
			'query' => [
				'CustomerNumber' => $customerNumber,
				'Username'       => $username,
				'Password'       => $password
			],
		], false );

		$token = trim($token, '"'); // Fix double-quotes wrapping the returned data.

		$this->setAuthToken( $token );
		$this->auth();

		return $this;
	}

	/**
	 * Create case in DKS system. The API returns nothing,
	 * so this method will return true if it succeeded, or
	 * throw an exception with the error message if it failed.
	 *
	 * @param CaseItem $case
	 *
	 * Der skal foreligge en accept fra kreditor af følgende betingelser før at en sag må oprettes hos DKS:
	 *
	 * Som kreditor bekræfter jeg hermed:
	 * - At der ved oprettelse af et inkassovarsel, er fremsendt faktura til debitor og at denne
	 * ikke har gjort indsigelser mod kravet.
	 *
	 * - At der ved oprettelse af en inkassosag, er fremsendt faktura og inkassovarsel til debitor
	 * og at denne ikke har gjort indsigelser mod kravet.
	 *
	 * Såfremt det senere viser sig, at de indtastede oplysninger ikke er korrekte, forbeholder DKS
	 * A/S sig retten til at opkræve sagens omkostninger hos kreditor.
	 *
	 * Det må ikke kunne lade sig gøre at oprette en sag hos DKS uden at kreditor har accepteret ovenstående.
	 *
	 * @return bool
	 */
	public function sendCase( CaseItem $case ) {
		$this->request->post( 'send-case', [
			'json' => $case->toArray()
		] );

		return true;
	}

	public function statuses() {
		return $this->request->get( 'status' );
	}

	private function auth() {
		$this->request = new Request( $this->authToken, $this->clientConfig, $this->test );

		return $this;
	}

	private function setAuthToken( $token ) {
		$this->authToken = $token;
	}

	private function getAuthToken() {
		return $this->authToken;
	}
}
