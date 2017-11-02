<?php

namespace Milo\Github\OAuth;

use Milo\Github;


/**
 * Configuration for OAuth token obtaining.
 *
 * @author  Miloslav Hůla (https://github.com/milo)
 */
class Configuration extends Github\Sanity
{
	/** @var string */
	public $clientId;

	/** @var string */
	public $clientSecret;

	/** @var string[] */
	public $scopes;

	/**
	 * @param       $clientId
	 * @param       $clientSecret
	 * @param array $scopes
	 * @internal param $string
	 * @internal param $string
	 * @internal param $string []
	 */
	public function __construct($clientId, $clientSecret, array $scopes = [])
	{
		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->scopes = $scopes;
    }

	/**
	 * @param array $conf
	 * @return \Milo\Github\OAuth\Configuration
	 */
	public static function fromArray(array $conf)
	{
		return new static($conf['clientId'], $conf['clientSecret'], isset($conf['scopes']) ? $conf['scopes'] : []);
	}

}
