@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        المدفوعات     <h4 class="card-title"> الدرج ({{ ($sum + $shift?->start_cash) - $expenses }}) </h4>
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
</x-dashboard.base.nav>
<!-- Nav Header Component End -->
<!--Nav End-->
</div>
{{-- content --}}
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"> المبيعات ({{ $sum }}) </h4>
                        </div>
                        @if ($expenses !== 0)
                        <div class="header-title">
                            <h4 class="card-title">  المصروفات ({{ $expenses }}) </h4>
                        </div>
                        <div class="header-title">
                            <h4 class="card-title">  الصافي ({{ $sum - $expenses }}) </h4>
                        </div>
                        @endif
                        <div class="header-title">
                            <h4 class="card-title"> استلام ({{ $shift?->start_cash }}) </h4>
                        </div>
                        <div class="header-title">
                            <h4 class="card-title"> تسليم ({{ $shift?->end_cash }}) </h4>
                        </div>
                        <div class="header-title">
                            <h4 class="card-title"> عدد الفواتير ({{ $count }}) </h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        @php
                        $today = date('Y-m-d');
                        @endphp
                        <form action="{{ route('invoices.index') }}" method="get" style="padding: 20px;">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">عرض من تاريخ</label>
                                    <input type="date" class="form-control" name="from"
                                        value="{{ request('from', $today) }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">الي تاريخ</label>
                                    <input type="date" class="form-control" name="to"
                                        value="{{ request('to', $today) }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">الكاشير</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">اختر الكاشير </option>
                                        @foreach ($users as $user)
                                        <option value="{{$user->id}}">
                                            {{$user->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">الوردية</label>
                                    <select class="form-control" name="shift_id">
                                        <option value=""> الورديات </option>
                                        @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ $shift->status == 1 ? 'selected' : '' }}
                                            {{ $shift->status == 1 ? 'style=background-color:green' : '' }}>
                                             {{ $shift->status == 1 ? ' (الحالية)' : '' }} -  {{ $shift->getType() }} - {{ $shift->user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="col-md-4" style=" margin-top: 30px !important;">
                                <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-search"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                                <a class="btn btn-danger" href="{{ route('invoices.index')}}"><span
                                        aria-hidden="true">&times;</span></a>
                            </div>
                    </div>
                    </form>
                    <div class="table-responsive">
                        <table id="user-list-table" class="table table-striped" role="grid">
                            <thead>
                                <tr class="ligth">
                                    <th class="text-center">#</th>
                                    <th>رقم الفاتورة</th>
                                    <th>المستخدم</th>
                                    <th>الورددية</th>
                                    <th>العميل</th>
                                    <th>نوع الخدمة</th>
                                    <th>اجمالي الفاتورة</th>
                                    <th>التاريخ</th>
                                    <th style="min-width: 100px">الإعدادات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $index=>$invoice)
                                <tr>
                                    <td class="text-center">{{ $index+1 }}</td>
                                    <td>{{ $invoice->number }}</td>
                                    <td>{{ $invoice->user->name }}</td>
                                    <td>{{ $invoice->shift->getType() }}</td>
                                    <td>{{ $invoice->client->name }}</td>
                                    <td>{{ $invoice->service?->name }}</td>
                                    <td>{{ $invoice->total_price }}</td>
                                    <td>{{ $invoice->updated_at }}</td>
                                    <td>
                                        <div class="flex align-items-center list-user-action" style="display: flex;">
                                            {{-- <x-dashboard.a-edit href="{{ route('orders.edit', $invoice->id) }}">
                                            </x-dashboard.a-edit>&nbsp; --}}
                                            <x-dashboard.a-show href="{{ route('orders.show', $invoice->id) }}">
                                            </x-dashboard.a-show>&nbsp;
                                            <form action="{{ route('orders.destroy', $invoice->id) }}" method="POST">
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

                        @if ($invoices instanceof \Illuminate\Pagination\LengthAwarePaginator && $invoices->hasPages())
                            {{ $invoices->withQueryString()->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function openmodle(url){
    document.getElementById("iframe").src=url;
  }
</script>
@endsection
