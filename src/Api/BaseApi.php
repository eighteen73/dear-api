<?php

/**
 * Part of Dear package.
 *
 * @package Dear
 * @version 1.0
 * @author Umair Mahmood
 * @license MIT
 * @copyright Copyright (c) 2019 Umair Mahmood
 *
 */

namespace Eighteen73\Dear\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Eighteen73\Dear\Api\Contracts\DeleteMethodAllowed;
use Eighteen73\Dear\Api\Contracts\PostMethodAllowed;
use Eighteen73\Dear\Api\Contracts\PutMethodAllowed;
use Eighteen73\Dear\Config;
use Eighteen73\Dear\Exception\BadRequestException;
use Eighteen73\Dear\Exception\DearApiException;
use Eighteen73\Dear\Exception\ForbiddenRequestException;
use Eighteen73\Dear\Exception\InternalServerErrorException;
use Eighteen73\Dear\Exception\MethodNotAllowedException;
use Eighteen73\Dear\Exception\NotFoundException;
use Eighteen73\Dear\Exception\ServiceUnavailableException;
use Eighteen73\Dear\Helper;
use Eighteen73\Dear\RESTApi;
use GuzzleHttp\Utils;

abstract class BaseApi implements RESTApi
{
    /**
     * Default limit
     */
    public const LIMIT = 100;
    /**
     * Default page
     */
    public const PAGE = 1;

    /**
     * HTTP request content type
     */
    public const CONTENT_TYPE = 'application/json';

    /**
     * @var Config
     */
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Provide endpoint's action name
     */
    abstract protected function getAction(): string;

    /**
     * Represents the GUID column name
     */
    abstract protected function getGUID(): string;

    /**
     * GUID column name for delete action
     */
    protected function deleteGUID(): string
    {
        return 'ID';
    }

    /**
     * Returns required headers
     */
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => self::CONTENT_TYPE,
            'api-auth-accountid' => $this->config->getAccountId(),
            'api-auth-applicationkey' => $this->config->getApplicationKey()
        ];
    }

    protected function getClient(): Client
    {
        return new Client([
            'base_uri' => $this->getBaseUrl()
        ]);
    }

    final protected function getBaseUrl(): string
    {
        return 'https://inventory.dearsystems.com/ExternalApi/v2/';
    }

    final public function get(array $parameters = []): array
    {
        return $this->execute('GET', Helper::prepareParameters($parameters));
    }

    final public function find(string $guid, array $parameters = []): array
    {
        $parameters[$this->getGUID()] = $guid;
        return $this->execute('GET', Helper::prepareParameters($parameters));
    }

    final public function create(array $parameters = []): array
    {
        if (!$this instanceof PostMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        return $this->execute('POST', $parameters);
    }

    final public function update(string $guid, array $parameters = []): array
    {
        if (!$this instanceof PutMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        $parameters[$this->getGUID()] = $guid;
        return $this->execute('PUT', $parameters);
    }

    final public function delete(string $guid, array $parameters = []): array
    {
        if (!$this instanceof DeleteMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        $parameters[$this->deleteGUID()] = $guid;
        return $this->execute('DELETE', Helper::prepareParameters($parameters));
    }

    /**
     * @throws BadRequestException
     * @throws DearApiException
     * @throws ForbiddenRequestException
     * @throws InternalServerErrorException
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws GuzzleException
     */
    protected function execute(string $httpMethod, array $parameters): array
    {
        try {
            $requestParams = [
                'headers' => $this->getHeaders()
            ];

            if ($httpMethod == 'POST' || $httpMethod == 'PUT') {
                $requestParams['body'] = json_encode($parameters);
            } else {
                $requestParams['query'] = $parameters;
            }

            $response = $this->getClient()->request($httpMethod, $this->getAction(), $requestParams);
            return Utils::jsonDecode((string)$response->getBody(), true);

        } catch (ClientException $clientException) {
            return $this->handleClientException($clientException);

        } catch (ServerException $serverException) {
            if ($serverException->getResponse()->getStatusCode() === 503) {
                // API limit exceeded
                sleep(5);

                return $this->execute($httpMethod, $parameters);
            }

            return $this->handleServerException($serverException);
        }
    }

    protected function handleClientException(ClientException $e): void
    {
        $response = $e->getResponse();
        $exceptionClass = match ($response->getStatusCode()) {
            400 => BadRequestException::class,
            403 => ForbiddenRequestException::class,
            404 => NotFoundException::class,
            405 => MethodNotAllowedException::class,
            default => DearApiException::class,
        };

        $exceptionInstance = new $exceptionClass($e->getMessage());
        $exceptionInstance->setStatusCode($response->getStatusCode());

        throw $exceptionInstance;
    }

    protected function handleServerException(ServerException $e)
    {
        $response = $e->getResponse();
        $exceptionClass = match ($response->getStatusCode()) {
            500 => InternalServerErrorException::class,
            503 => ServiceUnavailableException::class,
            default => DearApiException::class,
        };

        $exceptionInstance = new $exceptionClass($e->getMessage());
        $exceptionInstance->setStatusCode($response->getStatusCode());

        throw $exceptionInstance;
    }
}