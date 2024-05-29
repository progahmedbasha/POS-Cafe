<!DOCTYPE html>
<html lang="en" dir="rtl">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            th,
            td {
                font-size: 15px;
                text-align: right;
                font-weight: bold;
            }

            .detail td {
                border: 1px solid gray;
            }

            body {
                margin: 0;
                padding: 0;
                height: auto;
            }

            /*
@page {
    size: A4;
    margin: 0;
}*/

            /*@media print {
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}*/
        </style>
    </head>

    <body onload="window.print()">
        {{--<div class="page">--}}
        <center>
            <div id="elem" style="text-align:center;width:250px;height:auto;font-size:12px;">
                <span style="font-size:68px;"><b>Rokna</b></span><br>
                <span style="font-size:22px;">Cafe & Playstaion</span><br>
                <br><br><br>
                <table class="detail" width="100%">
                    <tr>
                        <td>رقم : {{$order->number}}</td>
                        {{-- <td>{{$order->number}}</td> --}}
                        <td>وقت : {{$order->created_at}}</td>
                        {{-- <td>{{$order->created_at}}</td> --}}
                    </tr>
                    <tr>
                        <td>موظف: {{ $order->user->name }}</td>
                        <td>عميل: {{ $order->client->name }}</td>
                    </tr>
                    <tr>
                        <td>
                            @if ($order->type == 1)
                            طاولة : {{ $order->service->name }}
                            @endif
                            @if ($order->type == 2)
                            Room : {{ $order->service->name }}
                            @endif
                        </td>
                    </tr>
                </table>
                <br>
                {{-- <h5>{{ $order->service->name }}</h5> --}}
                <hr>
                <table>
                    <tr>
                        <th style="width:200px;">الصنف</th>
                        <th>ملاحظة</th>
                        <th>الكمية</th>
                    </tr>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td style="width: 50%;">{{ $item->note }}</td>
                        <td>{{ $item->qty }}</td>
                    </tr>
                    @endforeach
                </table>
                @if ($order->note !=null)
                <hr>
                <h5>ملاحظة : {{ $order->note }}</h5>
                <hr>
                @endif
                <br>
            </div>
        </center>
        {{--</div>--}}
    </body>