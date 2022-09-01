<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessageEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public string $message;
  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct (string $message)
  {
    $this->message = $message;
  }

  /**
   * The event's broadcast name.
   *
   * @return string
   */
//  public function broadcastAs()
//  {
//    return 'new';
//  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return Channel|array
   */
  public function broadcastOn (): Channel|array
  {
    return new Channel('chat');
  }
}
