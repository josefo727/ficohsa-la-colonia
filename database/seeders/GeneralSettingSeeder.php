<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'name' => 'PIXELPAY_URL_BASE',
                'value' => 'https://pixelpay.app/api/v2/transaction/hosted/sandbox',
                'description' => 'Url base del servicio pixelpay.',
                'type' => 'url',
            ],
            [
                'name' => 'PIXELPAY_KEY_ID',
                'value' => '1234567890',
                'description' => 'Key o Key ID de pixelpay.',
                'type' => 'password',
            ],
            [
                'name' => 'PIXELPAY_HASH',
                'value' => '@s4ndb0x-abcd-1234-n1l4-p1x3l',
                'description' => 'Hash de pixelpay.',
                'type' => 'password',
            ],
            [
                'name' => 'VTEX_ACCOUNT_NAME',
                'value' => 'massivespacenew',
                'description' => 'Nombre de la cuenya en Vtex.',
                'type' => 'string',
            ],
            [
                'name' => 'VTEX_ENVIRONMENT',
                'value' => 'vtexcommercestable',
                'description' => 'Entorno API Vtex.',
                'type' => 'string',
            ],
            [
                'name' => 'VTEX_APP_KEY',
                'value' => 'vtexappkey-massivespacenew-TXNDVP',
                'description' => 'App key de Vtex.',
                'type' => 'password',
            ],
            [
                'name' => 'VTEX_APP_TOKEN',
                'value' => 'EPYJLVTYILXHWGHPVFNPZKALRKJNRLNTJQVVPSROBYAJGIPGDJPQRAHKWVTGENBKANPBGCNCXGDGKGOQZPKFRSQNSGAYGYIDHYVHQJQETIOCNWADWFMWSKJIJPTDBSLW',
                'description' => 'App token de Vtex.',
                'type' => 'password',
            ],
            [
                'name' => 'VTEX_PAYMENT_SYSTEM',
                'value' => '17',
                'description' => 'Código de pixelpay en Vtex.',
                'type' => 'array',
            ],
            [
                'name' => 'VTEX_MASTER_DOMAIN',
                'value' => 'https://massivespacenew.myvtex.com',
                'description' => 'Dominio master tienda vtex.',
                'type' => 'string',
            ],
            [
                'name' => 'VTEX_PRODUCTION_DOMAIN',
                'value' => 'https://massivespacenew.myvtex.com',
                'description' => 'Dominio de producción tienda vtex.',
                'type' => 'string',
            ],

        ];

        foreach ($settings as $setting) {
            GeneralSetting::create($setting);
        }
    }
}
