<?php

namespace console\components;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use tasktracker\entities\task\Comments;
use tasktracker\repositories\TaskRepository;
use tasktracker\services\TaskService;

class WsComments implements MessageComponentInterface
{
    private $clients = [];
    private $clientTask = [];
    private $service;
    private $tasks;

    /**
     * WsComments constructor.
     * @param TaskService $service
     * @param TaskRepository $tasks
     */
    public function __construct(TaskService $service, TaskRepository $tasks)
    {
        $this->service = $service;
        $this->tasks = $tasks;
    }


    /**
     * When a new connection is opened it will be passed to this method
     * @param ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        echo 'Open connection ' . $conn->resourceId . PHP_EOL;
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        unset($this->clients[$this->clientTask[$conn->resourceId]][$conn->resourceId]);
        unset($this->clientTask[$conn->resourceId]);
        echo 'Close connection ' . $conn->resourceId . PHP_EOL;
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo 'Error' . $e->getMessage() . PHP_EOL;
    }

    /**
     * Triggered when a client sends data through the socket
     * @param ConnectionInterface $from The socket/connection that sent the message to your application
     * @param string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, false);
        if ($data->identity) {
            $this->saveClient($from, $data);
            return;
        }
        $comment = $this->service->createComment($data->comment, $data->taskId, $data->userId);
        if ($comment) {
            $this->sendMessage($comment);
        }
    }

    function saveClient(ConnectionInterface $from, $data)
    {
        $resourceId = $from->resourceId;
        $taskId = $data->taskId;

        $this->clientTask[$resourceId] = $taskId;
        $this->clients[$taskId][$resourceId] = $from;

        echo "Save connection {$resourceId} on task {$taskId}\n";
    }

    function sendMessage(Comments $comment)
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
            echo $client->resourceId . PHP_EOL;
            $client->send(json_encode($message));
        }
    }
}