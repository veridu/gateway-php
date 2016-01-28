<?php

namespace Veridu\Gateway;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

final class Redirect {
	private $key;
	private $secret;
	private $gatewayUrl;
	private $callbackUrl = null;
	private $templateName = null;
	private $signatureTtl = 3600;
	private $tokenId = null;

	const VERSION = '0.1.0';

	private function generateTokenId() {
		if (function_exists('random_bytes'))
			$this->tokenId = bin2hex(random_bytes(10));
		else if (function_exists('openssl_random_pseudo_bytes'))
			$this->tokenId = bin2hex(openssl_random_pseudo_bytes(10));
		else
			$this->tokenId = uniqid();
		return $this->tokenId;
	}

	public function __construct($key, $secret, $gatewayUrl = 'https://gateway.veridu.com/1.1/widget') {
		$this->key = $key;
		$this->secret = $secret;
		$this->gatewayUrl = $gatewayUrl;
	}

	public function generateUrl($username = null) {
		$now = time();
		$builder = new Builder;
		$token = $builder
			->setIssuer($this->key)
			->setAudience($this->gatewayUrl)
			->setSubject($username)
			->setId($this->generateTokenId())
			->set('url', $this->callbackUrl)
			->set('tpl', $this->templateName)
			->setIssuedAt($now)
			->setNotBefore($now)
			->setExpiration($now + $this->signatureTtl)
			->sign(new Sha256, $this->secret)
			->getToken();
		return sprintf(
			'%s?token=%s',
			$this->gatewayUrl,
			$token
		);
	}

	public function setCallbackUrl($callbackUrl) {
		if (filter_var($callbackUrl, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) === false)
			throw new Exception\InvalidCallbackURL;
		$this->callbackUrl = $callbackUrl;
		return $this;
	}

	public function getCallbackUrl() {
		return $this->callbackUrl;
	}

	public function setTemplateName($templateName) {
		if (!preg_match('/^[a-zA-Z0-9_-]+$/', $templateName))
			throw new Exception\InvalidTemplateName;
		$this->templateName = $templateName;
		return $this;
	}

	public function getTemplateName() {
		return $this->templateName;
	}

	public function setSignatureTtl($signatureTtl) {
		if (filter_var($signatureTtl, FILTER_VALIDATE_INT) === false)
			throw new Exception\InvalidSignatureTTL;
		$this->signatureTtl = intval($signatureTtl);
		return $this;
	}

	public function getSignatureTtl() {
		return $this->signatureTtl;
	}

	public function getTokenId() {
		return $this->tokenId;
	}

}
