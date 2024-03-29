<?php

namespace App\Controller;

use App\Model\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveContact implements RequestHandlerInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $contactId = filter_var($request->getQueryParams()['id'], FILTER_VALIDATE_INT);

        if (false === $contactId) {
            http_response_code(401);

            return new Response(401, ['Content-Type' => 'application/json'], json_encode([
                'status' => 'error',
                'message' => 'Contact not found',
            ]));
        }

        $contact = $this->entityManager->find(Contact::class, $contactId);

        if (null === $contact) {
            http_response_code(401);

            return new Response(401, ['Content-Type' => 'application/json'], json_encode([
                'status' => 'error',
                'message' => 'Contact not found',
            ]));
        }

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'status' => 'success',
            'message' => 'Contact removed',
        ]));
    }
}
