<?php

namespace App\Http\Middleware;

use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends Middleware
{
    const DEFAULT_AUTH_GUARD = 'web';

    protected function authenticate($request, array $guards): void
    {
        if (empty($guards)) {
            $guards = [null];
        }

        // Check the default guard and return early if it's not 'web'
        if ($this->shouldUnauthenticate($request)) {
            $this->unauthenticated($request, $guards);
            return;
        }

        $this->auth->shouldUse(self::DEFAULT_AUTH_GUARD);

        $user = $request->user();
        $panel = Filament::getCurrentPanel();

        if ($this->isNotAdmin($user, $panel)) {
            abort(403, 'You are not an Admin!');
        }
    }

    protected function redirectTo($request): ?string
    {
        return route('login');
    }

    protected function shouldUnauthenticate($request): bool
    {
        return self::DEFAULT_AUTH_GUARD !== 'web';
    }

    protected function isNotAdmin($user, $panel): bool
    {
        if ($user instanceof FilamentUser) {
            return !$user->canAccessPanel($panel);
        }
        return config('app.env') !== 'local';
    }
}
