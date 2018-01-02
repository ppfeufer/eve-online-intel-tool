<?php

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\GuzzleHttp\Promise;

/**
 * Interface used with classes that return a promise.
 */
interface PromisorInterface {
	/**
	 * Returns a promise.
	 *
	 * @return PromiseInterface
	 */
	public function promise();
}
