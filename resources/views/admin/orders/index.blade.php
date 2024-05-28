@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        المبيعـــات
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        {{-- <x-slot:link>
            {{ route('products.create') }}
        </x-slot> --}}
</x-dashboard.base.nav>
<!-- Nav Header Component End -->
<!--Nav End-->
</div>
{{-- content --}}
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">المبيعـــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead>
                                    <tr class="ligth">
                                        <th class="text-center">#</th>
                                        <th>رقم الفاتورة</th>
                                        <th>المستخدم</th>
                                        <th>العميل</th>
                                        <th>نوع الخدمة</th>
                                        <th>اجمالي الفاتورة</th>
                                        <th>التاريخ</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $index=>$order)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $order->number }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ $order->service->name }}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>{{ $order->updated_at }}</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                {{-- <x-dashboard.a-edit href="{{ route('orders.edit', $order->id) }}">
                                                </x-dashboard.a-edit>&nbsp; --}}
                                                <x-dashboard.a-show href="{{ route('orders.show', $order->id) }}">
                                                </x-dashboard.a-show>&nbsp;
                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-dashboard.delete-button></x-dashboard.delete-button>
                                                </form>&nbsp;
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection