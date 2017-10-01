<?php
namespace TuxBoy;

use GuzzleHttp\Psr7\Response;

class Redirect extends Response
{

    public function __construct(string $path)
    {
        parent::__construct(200, ['location' => $path]);
    }

}