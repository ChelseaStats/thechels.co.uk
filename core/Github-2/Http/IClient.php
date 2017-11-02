<?php

namespace Milo\Github\Http;


/**
 * HTTP client interface.
 *
 * @author  Miloslav Hůla (https://github.com/milo)
 */
interface IClient
{
	/**
	 * @param \Milo\Github\Http\Request $request
	 * @return \Milo\Github\Http\Response
	 */
	function request(Request $request);

	/**
	 * @param  callable|NULL
	 * @return self
	 */
	function onRequest($callback);

	/**
	 * @param  callable|NULL
	 * @return self
	 */
	function onResponse($callback);

}
