<?php

namespace App\TitleStatusPairs\Parser;

use App\TitleStatusPairs\Models\Pair;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class ResponseParser
{
    public function parse(ResponseInterface $response) : Pair
    {
        $statusCode = $response->getStatusCode();
        $dom = new Crawler((string) $response->getBody());
        $title = $dom->filterXPath('//head/title')->text(); // Could be a number of issues here but I don't want to overdo it
                                                            // i.e. more than one title... no title... malformed html etc. all could
                                                            // be an issue here. Would be picked up in tests.
        return new Pair(
            $title,
            $statusCode
        );
    }
}