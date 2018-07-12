<?php
namespace api\V1\Rest\Visits;

class VisitsResourceFactory
{
    public function __invoke($services)
    {
        return new VisitsResource();
    }
}
