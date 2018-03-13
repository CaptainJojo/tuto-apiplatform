<?php

namespace App\Subscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Book;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Google\Cloud\PubSub\PubSubClient;
use Psr\Log\LoggerInterface;

final class PubSubSubscriber implements EventSubscriberInterface
{
    private $logger;
    private $pubSubClient;

    public function __construct(PubSubClient $pubSubClient, LoggerInterface $logger)
    {   
        $this->pubSubClient = $pubSubClient;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['sendPubSub', EventPriorities::POST_RESPOND],
        ];
    }

    public function sendPubSub(FilterResponseEvent $event)
    {
        $topic = $this->pubSubClient->topic("response-json");
        $topic->publish(['data' => json_encode($event->getResponse()->getContent())]);
        $this->logger->info('send in pubsub');
    }
}