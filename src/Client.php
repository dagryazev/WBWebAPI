<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class Client
{
    public $responseCode = 0;
    public $responsePhrase = null;
    public $responseHeaders = [];
    public $rawResponse = null;
    public $response = null;
    public $requestPath = null;
    private HttpClient $Client;

    function __construct(HttpClient $client)
    {
        $this->Client = $client;
    }

    /**
     * @throws RequestException
     * @throws ClientException
     * @throws InvalidArgumentException
     */
    public function request(string $path, array $params = [], string $method = 'GET', array $addonHeaders = [])
    {
        $this->responseCode = 0;
        $this->responsePhrase = null;
        $this->responseHeaders = [];
        $this->rawResponse = null;
        $this->response = null;
        $this->requestPath = $path;

        try {
            switch (strtoupper($method)) {
                case 'GET':
                    $response = $this->Client->get($path, [
                        'headers' => array_merge([
                            'Accept' => '*/*',
                            ], $addonHeaders),
                        'query' => $params,
                    ]);
                    break;
                case 'POST':
                    $response = $this->Client->post($path, [
                        'headers' => array_merge([
                            'Accept' => '*/*',
                            ], $addonHeaders),
                        'body' => json_encode($params)
                    ]);
                    break;
                case 'FORM':
                    $response = $this->Client->post($path, [
                        'headers' => array_merge([
                            'Accept' => '*/*',
                            ], $addonHeaders),
                        'form_params' => $params
                    ]);
                    break;

                default:
                    throw new InvalidArgumentException('Unsupported request method: ' . strtoupper($method));
            }
        } catch (RequestException | ClientException $exc) {
            if ($exc->hasResponse()) {
                $jsonDecoded = json_decode($exc->getResponse()->getBody()->getContents());
                if (!json_last_error()) {
                    return $jsonDecoded;
                }
            }
            throw $exc;
        }

        $this->responseCode = $response->getStatusCode();
        $this->responsePhrase = $response->getReasonPhrase();
        $this->responseHeaders = $response->getHeaders();

        $responseContent = $response->getBody()->getContents();
        $this->rawResponse = $responseContent;

        $jsonDecoded = json_decode($responseContent);

        $this->response = (json_last_error() ? $responseContent : $jsonDecoded);

        return $this->response;
    }

}
