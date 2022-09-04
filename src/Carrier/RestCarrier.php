<?php

namespace Zea\RestLibrary\Carrier;

use Zea\RestLibrary\Contracts\Carrier;
use Zea\RestLibrary\Exceptions\PlacetoPayException;
use Zea\RestLibrary\Exceptions\PlacetoPayServiceException;
use Zea\RestLibrary\Message\CollectRequest;
use Zea\RestLibrary\Message\ProcessRequest;
use Zea\RestLibrary\Message\ProcessResponse;
use Zea\RestLibrary\Message\RedirectInformation;
use Zea\RestLibrary\Message\RedirectRequest;
use Zea\RestLibrary\Message\RedirectResponse;
use Zea\RestLibrary\Message\ReverseResponse;
use GuzzleHttp\Exception\BadResponseException;
use Throwable;

class RestCarrier extends Carrier
{
    private function makeRequest(string $url, object $arguments): array
    {
        $instrument = $arguments->instrument();

        $arguments = $arguments->toArray();

        try {
            $data = array_merge($arguments, [
                'auth' => $this->settings->authentication()->asArray(),
                'instrument' => $instrument
                ]);

            $this->settings->logger()->debug('REQUEST', $data);
            $response = $this->settings->client()->post($url, [
                'json' => $data,
                'headers' => $this->settings->headers(),
            ]);

            $result = $response->getBody()->getContents();

            $this->settings->logger()->debug('RESPONSE', [
                'result' => $result,
            ]);
        } catch (BadResponseException $exception) {
            $result = $exception->getResponse()->getBody()->getContents();
            $this->settings->logger()->warning('BAD_RESPONSE', [
                'class' => get_class($exception),
                'result' => $result,
            ]);
        } catch (Throwable $exception) {
            $this->settings->logger()->warning('EXCEPTION_RESPONSE', [
                'exception' => PlacetoPayException::readException($exception),
            ]);
            throw PlacetoPayServiceException::fromServiceException($exception);
        }

        return json_decode($result, true);
    }

    public function request(RedirectRequest $redirectRequest): RedirectResponse
    {
        $result = $this->makeRequest($this->settings->baseUrl('api/session'), $redirectRequest->toArray());
        return new RedirectResponse($result);
    }

    public function process(ProcessRequest $processRequest): ProcessResponse
    {
        $result = $this->makeRequest($this->settings->baseUrl('gateway/process'), $processRequest);
        return new ProcessResponse($result);
//        return new ProcessResponse($result);
    }

    public function query(string $requestId): RedirectInformation
    {
        $result = $this->makeRequest($this->settings->baseUrl('api/session/' . $requestId), []);
        return new RedirectInformation($result);
    }

    public function collect(CollectRequest $collectRequest): RedirectInformation
    {
        $result = $this->makeRequest($this->settings->baseUrl('api/collect'), $collectRequest->toArray());
        return new RedirectInformation($result);
    }

    public function reverse(string $transactionId): ReverseResponse
    {
        $result = $this->makeRequest($this->settings->baseUrl('api/reverse'), [
            'internalReference' => $transactionId,
        ]);
        return new ReverseResponse($result);
    }
}
