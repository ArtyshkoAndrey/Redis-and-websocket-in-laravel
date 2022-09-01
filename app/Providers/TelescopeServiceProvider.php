<?php

namespace App\Providers;

use Laravel\Telescope\Telescope;
use Laravel\Telescope\IncomingEntry;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register (): void
  {
    Telescope::night();

    $this->hideSensitiveRequestDetails();

    Telescope::filter(function (IncomingEntry $entry) {
      if ($this->app->environment('local')) {
        return true;
      }

      return $entry->isReportableException() || $entry->isFailedRequest() || $entry->isFailedJob() || $entry->isScheduledTask() || $entry->hasMonitoredTag();
    });
  }

  /**
   * Prevent sensitive request details from being logged by Telescope.
   *
   * @return void
   */
  protected function hideSensitiveRequestDetails (): void
  {
    if ($this->app->environment('local')) {
      return;
    }

    Telescope::hideRequestParameters(['_token']);

    Telescope::hideRequestHeaders([
      'cookie',
      'x-csrf-token',
      'x-xsrf-token',
    ]);
  }

  /**
   * Register the Telescope gate.
   *
   * This gate determines who can access Telescope in non-local environments.
   *
   * @return void
   */
  protected function gate (): void
  {
    Gate::define('viewTelescope', static function ($user) {
      return in_array($user->email, [//
      ], true);
    });
  }
}