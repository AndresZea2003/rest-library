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
}
