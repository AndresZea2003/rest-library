<?php

namespace Zea\RestLibrary;

use Zea\RestLibrary\Exceptions\PlacetoPayException;
use Zea\RestLibrary\Helpers\Settings;
use Zea\RestLibrary\Message\CollectRequest;
use Zea\RestLibrary\Message\Notification;
use Zea\RestLibrary\Message\RedirectInformation;
use Zea\RestLibrary\Message\RedirectRequest;
use Zea\RestLibrary\Message\RedirectResponse;
use Zea\RestLibrary\Message\ReverseResponse;
use Zea\RestLibrary\Message\ProcessRequest;
use Zea\RestLibrary\Message\ProcessResponse;

class PlacetoPay
{
    protected Settings $settings;

    public function __construct(array $data)
    {
        $this->settings = new Settings($data);
    }

    public function process($processRequest): ProcessResponse
    {
        if (is_array($processRequest)) {
            $processRequest = new ProcessRequest($processRequest);
        }

        if (!($processRequest instanceof ProcessRequest)) {
            throw PlacetoPayException::forDataNotProvided('Wrong class request');
        }

        return $this->settings->carrier()->process($processRequest);
    }

    public function query(int $internalReference)
    {
        return $this->settings->carrier()->query($internalReference);
    }

    /**
     * @param RedirectRequest|array $redirectRequest
     * @throws PlacetoPayException
     */
    public function request($redirectRequest): RedirectResponse
    {
        if (is_array($redirectRequest)) {
            $redirectRequest = new RedirectRequest($redirectRequest);
        }

        if (!($redirectRequest instanceof RedirectRequest)) {
            throw PlacetoPayException::forDataNotProvided('Wrong class request');
        }

        return $this->settings->carrier()->request($redirectRequest);
    }
    /**
     * @param CollectRequest|array $collectRequest
     * @throws PlacetoPayException
     */
    public function collect($collectRequest): RedirectInformation
    {
        if (is_array($collectRequest)) {
            $collectRequest = new CollectRequest($collectRequest);
        }

        if (!($collectRequest instanceof CollectRequest)) {
            throw new PlacetoPayException('Wrong collect request');
        }

        return $this->settings->carrier()->collect($collectRequest);
    }

    public function reverse(string $internalReference): ReverseResponse
    {
        return $this->settings->carrier()->reverse($internalReference);
    }

    public function readNotification(array $data): Notification
    {
        return new Notification($data, $this->settings->tranKey());
    }
}
