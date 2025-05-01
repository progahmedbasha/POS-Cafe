@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        متابعة الأوردرات
        </x-slot>
         عرض جميع الأوردرات المحذوفة يمكنك اختيار أوردر ومتابعة تفاصيله
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
                            <h4 class="card-title">متابعة الأوردرات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        {{-- search --}}
                        <form method="get" action="{{route('orders_logs')}}" style="padding: 20px;"
                            style="margin-left: 70%;">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">رقم الفاتورة</label>
                                        <input type="text" class="form-control" placeholder="البحث عن فاتورة" name="number"
                                                value="{{ request('number') }}" />
                                </div>
                                <div class="col">
                                    <label class="form-label">الوردية</label>
                                    <select class="form-control" name="shift_id">
                                        <option value=""> الورديات </option>
                                        @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ $shift->id == request('shift_id') ? 'selected' : '' }}
                                            {{ $shift->status == 1 ? 'style=background-color:green' : '' }}>
                                             {{ $shift->status == 1 ? ' (الحالية)' : '' }} -  {{ $shift->getType() }} - {{ $shift->user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col"><br>
                                    <label class="form-label">عرض المحذوفات</label>
                                    <input type="checkbox" name="trashed" value="1" {{ request('trashed') == '1' ? 'checked' : '' }} />
                                </div>
                                <div class="col-md-4" style=" margin-top: 30px !important;">
                                    <button type="submit" class="btn btn-primary"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('orders_logs')}}"><span
                                            aria-hidden="true">&times;</span></a>
                                </div>
                            </div>

                        </form>
                        {{-- search --}}
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
                                                <x-dashboard.a-show href="{{ route('order_log_show', $order->id) }}">
                                                </x-dashboard.a-show>&nbsp;
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