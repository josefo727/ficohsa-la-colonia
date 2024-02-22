<?php

namespace App\Http\Middleware;

use Closure;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class SetConfigs
{
    /**
     * @param mixed $request
     * @param Closure(): void $next
     */
    public function handle($request, Closure $next)
    {
        $origin = $request->headers->get('origin');

        switch($origin) {
            case GeneralSetting::getValue('VTEX_PRODUCTION_DOMAIN'):
            case GeneralSetting::getValue('VTEX_MASTER_DOMAIN'):
                app('config')->set('vtex.store_domain', $origin);
                break;
            default:
                $domainKey = app()->environment('production') ? 'VTEX_PRODUCTION_DOMAIN' : 'VTEX_MASTER_DOMAIN';
                $storeDomain = GeneralSetting::getValue($domainKey);
                app('config')->set('vtex.store_domain', $storeDomain);
        }

        return $next($request);
    }
}
