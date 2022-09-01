<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Notifications\TestMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SendTestMail implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected string $email;
  /**
   * Create a new job instance.
   *
   * @return void
   */
  public function __construct (string $email)
  {
    $this->email = $email;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle (): void
  {
    Notification::route('mail', $this->email)
      ->notify(new TestMail());
  }
}
