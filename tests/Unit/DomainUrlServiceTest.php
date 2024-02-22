<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Services\DomainUrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Josefo727\GeneralSettings\Models\GeneralSetting;

class DomainUrlServiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        GeneralSetting::create([
            'name' => 'VTEX_MASTER_DOMAIN',
            'value' => 'https://store.myvtex.com',
            'description' => 'Dominio master tienda vtex.',
            'type' => 'string'
        ]);

        GeneralSetting::create([
            'name' => 'VTEX_PRODUCTION_DOMAIN',
            'value' => 'https://storename.com',
            'description' => 'Dominio de producción tienda vtex.',
            'type' => 'string'
        ]);
    }


    /** @test */
    public function should_return_production_domain_when_origin_is_production_domain(): void
    {
        $origin = 'https://storename.com';

        $request = Request::create(route('api.order-info'), 'POST', ['order_id' => '1329930505111-01'], [], [], []);

        $request->headers->set('Origin', $origin);

        $this->assertEquals($origin, app(DomainUrlService::class)->generate($request));
    }

    /** @test */
    public function should_return_master_domain_when_origin_is_master_domain(): void
    {
        $origin = 'https://store.myvtex.com';

        $request = Request::create(route('api.order-info'), 'POST', ['order_id' => '1329930505111-01'], [], [], []);

        $request->headers->set('Origin', $origin);

        $this->assertEquals('https://store.myvtex.com', app(DomainUrlService::class)->generate($request));
    }

    /** @test */
    public function should_return_devjrg_store_when_origin_is_devjrg_store(): void
    {
        $origin = 'https://devjrg--store.myvtex.com';

        $request = Request::create(route('api.order-info'), 'POST', ['order_id' => '1329930505111-01'], [], [], []);

        $request->headers->set('Origin', $origin);

        $this->assertEquals($origin, app(DomainUrlService::class)->generate($request));
    }

    /** @test */
    public function should_return_master_domain_when_origin_is_null(): void
    {
        $origin = 'https://store.myvtex.com';

        $request = Request::create(route('api.order-info'), 'POST', ['order_id' => '1329930505111-01']);

        $request->headers->set('Origin', $origin);

        $this->assertEquals($origin, app(DomainUrlService::class)->generate($request));
    }

    /** @test */
    public function should_return_null_when_origin_is_invalid(): void
    {
        $origin = 'https://invalid.domain';

        $request = Request::create(route('api.order-info'), 'POST', ['order_id' => '1329930505111-01'], [], [], []);

        $request->headers->set('Origin', $origin);

        $this->assertNull(app(DomainUrlService::class)->generate($request));
    }

    /** @test */
    public function should_return_true_when_origin_is_workspace_and_matches_master(): void
    {
        $result = app(DomainUrlService::class)->isWorkspace('https://devjrg--massivespace.myvtex.com', 'https://massivespace.myvtex.com');
        $this->assertTrue($result);
    }

    /** @test */
    public function should_return_false_when_origin_is_workspace_and_does_not_match_master(): void
    {
        $result = app(DomainUrlService::class)->isWorkspace('https://devjrg--othersubdomain.myvtex.com', 'https://massivespace.myvtex.com');
        $this->assertFalse($result);
    }
}
