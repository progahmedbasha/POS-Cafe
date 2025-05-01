@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        متابعة الأوردرات
        </x-slot>
       
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
                            <h4 class="card-title">حركة الأوردر</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            @php
                                function getEventLabel($event) {
                                    return match($event) {
                                        'created' => 'إنشاء',
                                        'updated' => 'تحديث',
                                        'deleted' => 'مسح',
                                        default => $event
                                    };
                                }
                            @endphp
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>الحدث</th>
                                        <th>الوصف</th>
                                        <th>القيم القديمة</th>
                                        <th>القيم الجديدة</th>
                                        <th>المستخدم</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        @php
                                            $event = $log->event;
                                            $translatedEvent = getEventLabel($event);
                                            $rowClass = match($event) {
                                                'created' => 'table-success',
                                                'updated' => 'table-warning',
                                                'deleted' => 'table-danger',
                                                default => ''
                                            };
                                            $description = "تم {$translatedEvent} الطلب";
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td><strong>{{ $translatedEvent }}</strong></td>
                                            <td>{{ $description }}</td>
                                            <td>
                                                @if($log->properties['old'] ?? false)
                                                    <ul class="list-unstyled m-0">
                                                        @foreach($log->properties['old'] as $key => $value)
                                                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($log->properties['attributes'] ?? false)
                                                    <ul class="list-unstyled m-0">
                                                        @foreach($log->properties['attributes'] as $key => $value)
                                                            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ optional($log->user)->name ?? 'غير معروف' }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection