<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\Status;
use App\Http\Controllers\Api\OrderCancellationController;
use App\Models\Order;
use App\Services\OrderCancellationService;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class OrderCancellationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function should_cancel_order_successfully(): void
    {
        // Crear el mock del servicio
        $serviceMock = $this->mock(OrderCancellationService::class);
        $serviceMock->shouldReceive('cancelOrder')->andReturn(true);

        // Establecer el mock como una instancia vinculada en el contenedor de la aplicación
        App::instance(OrderCancellationService::class, $serviceMock);

        // Crear una instancia de la orden
        $order = Order::factory()->create([
        'status' => Status::NEEDS_APPROVAL,
        'order_id' => '123456'
        ]);

        // Simular la solicitud con el parámetro 'order_id'
        $response = $this->post(route('api.order-cancellation'), ['order_id' => '123456']);

        // Verificar la respuesta y el código de estado esperado
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJson([OrderCancellationController::MESSAGE_KEY => 'La orden ha sido cancelada exitosamente.']);
    }

    /** @test */
    public function should_return_order_not_found(): void
    {
        // Crear el mock del servicio
        $serviceMock = $this->mock(OrderCancellationService::class);

        // Establecer el mock como una instancia vinculada en el contenedor de la aplicación
        App::instance(OrderCancellationService::class, $serviceMock);

        // Simular la solicitud con un order_id inexistente
        $response = $this->post(route('api.order-cancellation'), ['order_id' => 'non-existent']);

        // Verificar la respuesta y el código de estado esperado
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson([OrderCancellationController::MESSAGE_KEY => 'La orden no ha sido encontrada.']);
    }

    /** @test */
    public function should_return_order_cancellation_failure(): void
    {
        // Crear el mock del servicio
        $serviceMock = $this->mock(OrderCancellationService::class);
        $serviceMock->shouldReceive('cancelOrder')->andReturn(false);

        // Establecer el mock como una instancia vinculada en el contenedor de la aplicación
        App::instance(OrderCancellationService::class, $serviceMock);

        // Crear una instancia de la orden
        $order = Order::factory()->create([
            'status' => Status::NEEDS_APPROVAL,
            'order_id' => '123456'
        ]);

        // Simular la solicitud con el parámetro 'order_id'
        $response = $this->post(route('api.order-cancellation'), ['order_id' => '123456']);

        // Verificar la respuesta y el código de estado esperado
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJson([OrderCancellationController::MESSAGE_KEY => 'La orden no pudo ser cancelada.']);
    }
}
