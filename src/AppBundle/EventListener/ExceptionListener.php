<?php

/*
 * This file is part of the SymfonyIdSkeleton package.
 *
 * (c) Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionListener
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ('prod' !== $this->kernel->getEnvironment()) {
            return;
        }

        $exception = $event->getException();
        $response = new Response();
        $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof HttpExceptionInterface) {
            if (400 < $exception->getStatusCode() && 500 > $exception->getStatusCode()) {
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
                $response->headers->replace($exception->getHeaders());
            }
        }

        $event->setResponse($response);
    }
}