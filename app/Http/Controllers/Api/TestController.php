<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendTestMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\SendMessageEvent;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Events\NewMessageInChatEvent;
use Psr\SimpleCache\InvalidArgumentException;

class TestController extends Controller
{
  public function put (Request $request): JsonResponse
  {
    $data = $request->get('message');
    Cache::store('redis')
      ->put('message', $data, 6000);
    return response()->json([
      'message' => $data,
    ]);
  }

  /**
   * @throws InvalidArgumentException
   */
  public function get (): JsonResponse
  {

    $message = Cache::store('redis')
      ->get('message');
    return response()->json([
      'message' => $message,
    ]);
  }

  public function createJob (Request $request)
  {
    $request->validate([
      'email' => 'email:rfc,dns',
    ]);
    $email = $request->get('email');
    SendTestMail::dispatch($email);

    return response()->json([
      'message' => 'Задача создалась',
    ]);
  }

  public function createTestMessage (): JsonResponse
  {
    $message = Str::random(8);

    broadcast(new SendMessageEvent($message));

    return response()->json(['message' => 'success']);
  }

  public function newMessage (Request $request)
  {
    $request->validate([
      'message' => 'required|string'
    ]);
    $message = $request->get('message');

    broadcast(new NewMessageInChatEvent($message));

    return response()->json(['message' => 'success']);
  }
}
