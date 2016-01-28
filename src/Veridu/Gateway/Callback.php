<?php

namespace Veridu\Gateway;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;

final class Callback {
	private $key;
	private $secret;
	private $gatewayUrl;
	private $username = null;
	private $pass = false;

	const VERSION = '0.1.0';

	public function __construct($key, $secret, $gatewayUrl = 'https://gateway.veridu.com/1.1/widget') {
		$this->key = $key;
		$this->secret = $secret;
		$this->gatewayUrl = $gatewayUrl;
	}

	public function checkCallbackSignature($token, $tokenId) {
		try {
			$parser = new Parser;
			$token = $parser->parse((string) $token);
		} catch (\RuntimeException $exception) {
			throw new Exception\InvalidToken;
		}

		$validation = new ValidationData;
		$validation->setIssuer($this->gatewayUrl);
		$validation->setAudience($this->key);
		$validation->setId($tokenId);

		if (!$token->validate($validation))
			throw new Exception\TokenValidationFailed;

		if (!$token->verify(new Sha256, $this->secret))
			throw new Exception\TokenVerificationFailed;

		if (!$token->hasClaim('sub'))
			throw new Exception\SubjectClaimMissing;
		$this->username = $token->getClaim('sub');

		if (!$token->hasClaim('pass'))
			throw new Exception\PassClaimMissing;
		$this->pass = $token->getClaim('pass');
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPass() {
		return $this->pass;
	}

}
