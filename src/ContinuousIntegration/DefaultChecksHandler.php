<?php

declare(strict_types=1);

namespace App\ContinuousIntegration;

use Mezzio\Hal\HalResource;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\Link;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DefaultChecksHandler implements RequestHandlerInterface
{
    private HalResponseFactory $responseFactory;

    public function __construct(HalResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resource = new HalResource(
            [
                'checks' => [
                    'cs-check',
                    'static-analysis',
                    'test',
                ],
            ],
            [new Link(
                'self',
                $request->getUri()->__toString()
            )]
        );

        return $this->responseFactory->createResponse(
            $request,
            $resource,
            'application/vnd.laminas.ci.default-checks'
        );
    }
}
