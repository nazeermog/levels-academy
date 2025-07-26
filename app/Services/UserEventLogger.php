<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DataSource\Entities\User\UserEvent;

class UserEventLogger
{
  public static function log(string $action, ?string $description = null, ?string $type = null) : void
  {
    $user = Auth::user();

    if ($user) {
      $description = $description ?? "{$user->first_name} performed {$action}";

      UserEvent::create([
        'user_id'    => $user->id,
        'role'       => $user->role,
        'action'     => $action,
        'description' => $description,
        'type'        => $type, 
      ]);
    }
  }
}
