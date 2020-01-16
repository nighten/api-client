<?php

namespace Nighten\ApiClient;

use Nighten\ApiClient\Request\RequestInterface;
use Nighten\ApiClient\Response\DefaultResponseHandler;
use Nighten\ApiClient\Response\ResponseHandlerInterface;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

class Client
{
    private string $host;

    private ?float $timeout = null;

    private ClientInterface $httpClient;

    private ?ResponseHandlerInterface $responseHandler;

    private ?LoggerInterface $logger;

    /**
     * Client constructor.
     * @param string $host
     * @param ClientInterface|null $httpClient
     * @param ResponseHandlerInterface|null $responseHandler
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        string $host,
        ?ClientInterface $httpClient = null,
        ?ResponseHandlerInterface $responseHandler = null,
        ?LoggerInterface $logger = null)
    {
        $this->host = preg_replace('#/$#', '', $host);
        $this->httpClient = $httpClient ?
            $httpClient :
            new \GuzzleHttp\Client();
        $this->responseHandler = $responseHandler;
        $this->logger = $logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param float $timeout
     */
    public function setTimeout(float $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @param ResponseHandlerInterface $responseHandler
     */
    public function setResponseHandler(ResponseHandlerInterface $responseHandler): void
    {
        $this->responseHandler = $responseHandler;
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(RequestInterface $request)
    {
        $response = $this->httpClient->request(
            $request->getMethod(),
            $this->host . $request->getPath(),
            $this->getOptions($request->getBody())
        );
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->info('Try API Request. Method:' . $request->getMethod() . ' Url:' . $this->host . $request->getPath());
        }
        return $this->getActualResponseHandler($request)->handle($response);
    }

    /**
     * @param string $rawBody
     * @return array
     */
    private function getOptions(?string $rawBody = null): array
    {
        $options = [];
        if ($rawBody !== null) {
            $options['body'] = $rawBody;
        }
        if ($this->timeout !== null) {
            $options['timeout'] = $this->timeout;
        }
        return $options;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient(ClientInterface $httpClient): void
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseHandlerInterface
     */
    private function getActualResponseHandler(RequestInterface $request): ResponseHandlerInterface
    {
        if ($this->responseHandler instanceof ResponseHandlerInterface) {
            return $this->responseHandler;
        }
        if ($request instanceof ResponseHandlerAwareInterface) {
            return $request->getResponseHandler();
        }
        return new DefaultResponseHandler();
    }
}
