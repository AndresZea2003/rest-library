<?php

namespace Zea\RestLibrary\Carrier;

use Zea\RestLibrary\Contracts\Carrier;
use Zea\RestLibrary\Entities\Status;
use Zea\RestLibrary\Exceptions\PlacetoPayException;
use Zea\RestLibrary\Helpers\ArrayHelper;
use Zea\RestLibrary\Message\CollectRequest;
use Zea\RestLibrary\Message\RedirectInformation;
use Zea\RestLibrary\Message\RedirectRequest;
use Zea\RestLibrary\Message\RedirectResponse;
use Zea\RestLibrary\Message\ReverseResponse;
use SoapClient;

/**
 * @deprecated
 */
class SoapCarrier extends Carrier
{
    private function client()
    {
        $config = [
            'soap_version' => SOAP_1_2,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => false,
            'encoding' => 'UTF-8',
            'location' => $this->settings->location(),
            'wsdl' => $this->settings->wsdl(),
        ];

        $wsdl = $config['wsdl'];
        unset($config['wsdl']);

        $client = new SoapClient($wsdl, $config);
        $client->__setSoapHeaders($this->settings->authentication()->asSoapHeader());

        return $client;
    }

    private function parseArguments($arguments)
    {
        return json_decode(json_encode($arguments));
    }

    public function request(RedirectRequest $redirectRequest): RedirectResponse
    {
        try {
            $arguments = $this->parseArguments([
                'payload' => $redirectRequest->toArray(),
            ]);
            $result = $this->client()->createRequest($arguments)->createRequestResult;
            return new RedirectResponse(ArrayHelper::asArray($result));
        } catch (\Exception $e) {
            return new RedirectResponse([
                'status' => [
                    'status' => Status::ST_ERROR,
                    'reason' => 'WR',
                    'message' => PlacetoPayException::readException($e),
                    'date' => date('c'),
                ],
            ]);
        }
    }

    public function query(string $requestId): RedirectInformation
    {
        try {
            $arguments = $this->parseArguments([
                'requestId' => $requestId,
            ]);
            $result = $this->client()->getRequestInformation($arguments)->getRequestInformationResult;
            return new RedirectInformation(ArrayHelper::asArray($result));
        } catch (\Exception $e) {
            return new RedirectInformation([
                'status' => [
                    'status' => Status::ST_ERROR,
                    'reason' => 'WR',
                    'message' => PlacetoPayException::readException($e),
                    'date' => date('c'),
                ],
            ]);
        }
    }

    public function collect(CollectRequest $collectRequest): RedirectInformation
    {
        try {
            $arguments = $this->parseArguments([
                'payload' => $collectRequest->toArray(),
            ]);
            $result = $this->client()->collect($arguments)->collectResult;
            return new RedirectInformation(ArrayHelper::asArray($result));
        } catch (\Exception $e) {
            return new RedirectInformation([
                'status' => [
                    'status' => Status::ST_ERROR,
                    'reason' => 'WR',
                    'message' => PlacetoPayException::readException($e),
                    'date' => date('c'),
                ],
            ]);
        }
    }

    public function reverse(string $transactionId): ReverseResponse
    {
        try {
            $arguments = $this->parseArguments([
                'internalReference' => $transactionId,
            ]);
            $result = $this->client()->reversePayment($arguments)->reversePaymentResult;
            return new ReverseResponse(ArrayHelper::asArray($result));
        } catch (\Exception $e) {
            return new ReverseResponse([
                'status' => [
                    'status' => Status::ST_ERROR,
                    'reason' => 'WR',
                    'message' => PlacetoPayException::readException($e),
                    'date' => date('c'),
                ],
            ]);
        }
    }
}
