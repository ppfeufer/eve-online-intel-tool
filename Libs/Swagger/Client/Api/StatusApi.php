<?php
/**
 * StatusApi
 * PHP version 7
 *
 * @category Class
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * EVE Swagger Interface
 *
 * An OpenAPI for EVE Online
 *
 * OpenAPI spec version: 0.7.3
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\ApiException;
use WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Configuration;
use WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\HeaderSelector;
use WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\ObjectSerializer;

/**
 * StatusApi Class Doc Comment
 *
 * @category Class
 * @package  WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class StatusApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation getStatus
     *
     * Retrieve the uptime and player counts
     *
     * @param  string $datasource The server name you would like data from (optional, default to tranquility)
     * @param  string $user_agent Client identifier, takes precedence over headers (optional)
     * @param  string $x_user_agent Client identifier, takes precedence over User-Agent (optional)
     *
     * @throws \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetStatusOk
     */
    public function getStatus($datasource = 'tranquility', $user_agent = null, $x_user_agent = null)
    {
        list($response) = $this->getStatusWithHttpInfo($datasource, $user_agent, $x_user_agent);
        return $response;
    }

    /**
     * Operation getStatusWithHttpInfo
     *
     * Retrieve the uptime and player counts
     *
     * @param  string $datasource The server name you would like data from (optional, default to tranquility)
     * @param  string $user_agent Client identifier, takes precedence over headers (optional)
     * @param  string $x_user_agent Client identifier, takes precedence over User-Agent (optional)
     *
     * @throws \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetStatusOk, HTTP status code, HTTP response headers (array of strings)
     */
    public function getStatusWithHttpInfo($datasource = 'tranquility', $user_agent = null, $x_user_agent = null)
    {
        $returnType = '\WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetStatusOk';
        $request = $this->getStatusRequest($datasource, $user_agent, $x_user_agent);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse()->getBody()->getContents()
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if ($returnType !== 'string') {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetStatusOk',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\InternalServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getStatusAsync
     *
     * Retrieve the uptime and player counts
     *
     * @param  string $datasource The server name you would like data from (optional, default to tranquility)
     * @param  string $user_agent Client identifier, takes precedence over headers (optional)
     * @param  string $x_user_agent Client identifier, takes precedence over User-Agent (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getStatusAsync($datasource = 'tranquility', $user_agent = null, $x_user_agent = null)
    {
        return $this->getStatusAsyncWithHttpInfo($datasource, $user_agent, $x_user_agent)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getStatusAsyncWithHttpInfo
     *
     * Retrieve the uptime and player counts
     *
     * @param  string $datasource The server name you would like data from (optional, default to tranquility)
     * @param  string $user_agent Client identifier, takes precedence over headers (optional)
     * @param  string $x_user_agent Client identifier, takes precedence over User-Agent (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getStatusAsyncWithHttpInfo($datasource = 'tranquility', $user_agent = null, $x_user_agent = null)
    {
        $returnType = '\WordPress\Plugin\EveOnlineIntelTool\Libs\Swagger\Client\Model\GetStatusOk';
        $request = $this->getStatusRequest($datasource, $user_agent, $x_user_agent);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getStatus'
     *
     * @param  string $datasource The server name you would like data from (optional, default to tranquility)
     * @param  string $user_agent Client identifier, takes precedence over headers (optional)
     * @param  string $x_user_agent Client identifier, takes precedence over User-Agent (optional)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getStatusRequest($datasource = 'tranquility', $user_agent = null, $x_user_agent = null)
    {

        $resourcePath = '/latest/status/';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($datasource !== null) {
            $queryParams['datasource'] = ObjectSerializer::toQueryValue($datasource);
        }
        // query params
        if ($user_agent !== null) {
            $queryParams['user_agent'] = ObjectSerializer::toQueryValue($user_agent);
        }
        // header params
        if ($x_user_agent !== null) {
            $headerParams['X-User-Agent'] = ObjectSerializer::toHeaderValue($x_user_agent);
        }


        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers= $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
