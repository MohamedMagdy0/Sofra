@extends('layouts.dashboard.app_master')
@section('page_title')
    Show
@endsection
@inject('settings', 'App\Models\Setting')

@section('content')
    <style>
        @media print {
            #printBtn {
                display: none;
            }
        }
    </style>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" id="print">


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">


                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Sofra, Inc.
                                    <small class="float-right">Date :
                                        {{ Carbon\Carbon::parse(date(now()))->format('d-m-Y | G:i a') }}</small>
                                </h4>
                            </div><!-- col-12 -->
                        </div><!-- info row -->


                        <div class="row invoice-info">

                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{ $order->restaurant->name }}, Inc.</strong><br>
                                    {{ $order->restaurant->district->city->name }}<br>
                                    {{ $order->restaurant->district->name }}<br>
                                    Phone: {{ $order->restaurant->phone }}<br>
                                    Email: {{ $order->restaurant->email }}
                                </address>
                            </div><!-- restaurant -->

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $order->client->name }}</strong><br>
                                    {{ $order->client->district->city->name }}<br>
                                    {{ $order->client->district->name }}<br>
                                    Phone: {{ $order->client->phone }}<br>
                                    Email: {{ $order->client->email }}
                                </address>
                            </div><!--  client -->
                            @php($key = 1)


                            <div class="col-sm-4 invoice-col">
                                <b>Invoice {{ $key++ }}</b><br>
                                <br>
                                <b>Order ID:</b> {{ $order->id }}<br>
                                <b>Payment Due:</b> {{ $order->created_at }}<br>
                                {{-- <b>Account:</b> 968-34567 --}}
                            </div> <!-- invoice -->

                        </div><!-- row invoice-info -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th>Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration  }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>-</td>
                                                <td>{{ $item->pivot->notes }}</td>
                                                <td>${{ $item->pivot->price }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->

                        <div class="row">


                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Payment Methods:</p>

                                <img src="{{ asset('admin/img/credit/visa.png') }}" alt="Visa">
                                <img src="{{ asset('admin/img/credit/mastercard.png') }}" alt="Visa">
                                <img src="{{ asset('admin/img/credit/cash-delivery.jpg') }}" height="55" alt="Visa">


                                {{-- <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                  </p> --}}
                            </div><!-- col-6 -->


                            <div class="col-6">
                                <p class="lead">Amount Due {{ Carbon\Carbon::parse(date(now()))->format('d-m-Y') }}</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>{{ number_format($order->total) }}</td>
                                        </tr>
                                        {{-- <tr>
                        <th>Tax ({{ $settings->commission }})</th>
                        <td>$10.34</td>
                      </tr> --}}
                                        <tr>
                                            <th>Shipping:</th>
                                            <td>{{ number_format($order->delivery_fee) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ number_format($order->total_price, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <button id="printBtn" onclick="printDiv(this)" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</button>

                                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit Payment</button> --}}

                                {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button> --}}

                            </div>
                        </div>
                    </div><!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->

    @push('scripts')
        <!-- start print code -->
        <script>
            function printDiv() {
                // alert();
                var print = document.getElementById('print').innerHTML;
                var content = document.body.innerHTML;
                document.body.innerHTML = print;
                window.print();
                document.body.innerHTML = content;
                location.reload();
            }
        </script>
        <!-- end print code -->
    @endpush
@endsection
