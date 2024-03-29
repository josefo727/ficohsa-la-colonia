<?php

namespace App\Services;

use Illuminate\Http\Request;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class DomainUrlService
{
    /*
     * @return string|null
     * @param Request $request
     */
    public function generate(Request $request): string|null
    {
        $origin = $request->headers->get('Origin');
        $masterDomain = GeneralSetting::getValue('VTEX_MASTER_DOMAIN');
        $productionDomain = GeneralSetting::getValue('VTEX_PRODUCTION_DOMAIN');

        if ($origin === $masterDomain) {
            return $masterDomain;
        }

        if ($origin === $productionDomain) {
            return $productionDomain;
        }

        if ($this->isWorkspace($origin, $masterDomain)) {
            return $origin;
        }

        if (!$origin) {
            return $masterDomain;
        }

        return null;
    }

    /**
     * @param mixed $origin
     * @param mixed $master
     */
    public function isWorkspace($origin, $master): bool
    {
        if (preg_match('/\.myvtex\.com$/', $origin) && strpos($origin, '--') !== false) {
            $sub = preg_replace('/^.*?--/', '', $origin);
            if (strpos($master, $sub) !== false) {
                return true;
            }
        }
        return false;
    }
}
