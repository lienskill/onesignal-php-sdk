<?php

namespace Kodjunkie\OnesignalPhpSdk\Endpoints;

use Kodjunkie\OnesignalPhpSdk\Exceptions\InvalidArgumentException;
use Kodjunkie\OnesignalPhpSdk\Http\ClientInterface;

abstract class Endpoint
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param ClientInterface $client
     * @param array $config
     */
    final public function __construct(ClientInterface $client, array $config = [])
    {
        $this->client = $client;
        $this->config = array_merge($config, [
            'app_id' => isset($config['app_id']) ? trim($config['app_id']) : null
        ]);
    }

    /**
     * @return ClientInterface
     */
    protected function client(): ClientInterface
    {
        return $this->client->setAuthKey($this->config['api_key']);
    }

    /**
     * @param string|null $appId
     * @return string
     * @throws InvalidArgumentException
     */
    final protected function getAppId(string $appId = null): string
    {
        if (is_null($appId) && is_null($this->config['app_id']))
            throw new InvalidArgumentException('Missing required parameter [app_id].');

        return is_null($appId) ? $this->config['app_id'] : trim($appId);
    }
}
