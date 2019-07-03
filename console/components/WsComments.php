<?php

namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use tasktracker\entities\task\Comments;
use tasktracker\services\TaskService;

class WsComments implements MessageComponentInterface
{
    private $clients = [];
    private $clientTask = [];
    private $service;

    /**
     * WsComments constructor.
     * @param TaskService $service
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }


    /**
     * When a new connection is opened it will be passed to this method
     * @param ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    public function onOpen(ConnectionInterface $conn): void
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        $taskId = explode('=', $queryString)[1];
        $this->saveClient($conn, $taskId);
        echo "Open connection {$conn->resourceId}\n";
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    public function onClose(ConnectionInterface $conn): void
    {
        $resourceId = $conn->resourceId;
        unset(
            $this->clients[$this->clientTask[$resourceId]][$resourceId],
            $this->clientTask[$resourceId]
        );
        echo "Close connection {$resourceId}\n";
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @throws \Exception
     */
    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        echo "Error {$e->getMessage()}\n";
    }

    /**
     * Triggered when a client sends data through the socket
     * @param ConnectionInterface $from The socket/connection that sent the message to your application
     * @param string $msg The message received
     * @throws \Exception
     */
    public function onMessage(ConnectionInterface $from, $msg): void
    {
        $data = json_decode($msg, false);

        $comment = $this->service->createComment($data->comment, $data->taskId, $data->userId);
        if ($comment) {
            $this->sendMessage($comment);
        }
    }

    public function saveClient(ConnectionInterface $from, int $taskId): void
    {
        $resourceId = $from->resourceId;

        $this->clientTask[$resourceId] = $taskId;
        $this->clients[$taskId][$resourceId] = $from;

        echo "Save connection {$resourceId} on task {$taskId}\n";
    }

    public function sendMessage(Comments $comment): void
    {
        $message = [
            'author' => $comment->author->username,
            'created' => $comment->created_at,
            'text' => $comment->text,
        ];
        /**
         * @var ConnectionInterface $client
         */
        foreach ($this->clients[$comment->task_id] as $client) {
            echo "Send message to client {$client->resourceId}\n";
            $client->send(json_encode($message));
        }
    }
}