@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Transactions</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(count($transactions) > 0)

                            <table class="table">
                                <tr>
                                    <td>Id</td>
                                    <td>Customer id</td>
                                    <td>Amount</td>
                                    <td>Date</td>
                                </tr>

                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->getId() }}</td>
                                        <td>{{ $transaction->getCustomerId() }}</td>
                                        <td>{{ $transaction->getAmount() }}</td>
                                        <td>{{ $transaction->getCreatedAt()->toDateString() }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            No transactions found
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection