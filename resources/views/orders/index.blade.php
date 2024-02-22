@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Órdenes</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Orden</th>
                    <th>Monto</th>
                    <th>Moneda</th>
                    <th>Status</th>
                    <th>Fecha de Creación</th>
                    <th style="text-align: center">Ver Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->amount }}</td>
                    <td>{{ $order->currency }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->order_creation_at }}</td>
                    <td style="text-align: center">
                        <a class="btn btn-sm btn-success"  data-bs-toggle="collapse" href="#transaction-{{ $order->id }}" role="button" aria-expanded="false" aria-controls="transaction-{{ $order->id }}">
                            Ver
                        </a>
                    </td>
                </tr>
                <tr class="collapse" id="transaction-{{ $order->id }}" style="background: #f1f1f1">
                    <td colspan="6">
                        @if($order->transaction)
                            <p>
                                Status: {{ $order->transaction->status }}<br />
                                Mensaje: {{ $order->transaction->message }} <br />
                                Fecha de pago: {{ $order->transaction->paid_at }} <br />
                                Id de transaction: {{ $order->transaction->transaction_id }} <br />
                                Payment hash: {{ $order->transaction->payment_hash }} <br />
                            </p>
                        @else
                            <p>
                                No existe transacción registrada a ésta orden.
                            </p>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
@endsection
