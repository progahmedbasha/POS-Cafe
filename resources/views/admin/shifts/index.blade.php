@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        الورديات
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        @if (!$isActiveShift)
        <x-slot:link>
            {{ route('shifts.create') }}
            </x-slot>
        @endif
</x-dashboard.base.nav>
<!-- Nav Header Component End -->
<!--Nav End-->
</div>
{{-- content --}}
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <iframe id="iframe" src="" style="display:none;"></iframe>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">الورديات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead>
                                    <tr class="ligth">
                                        <th class="text-center">#</th>
                                        <th>المستخدم</th>
                                        <th>استلام</th>
                                        <th>تسلم</th>
                                        <th>بداية الوقت</th>
                                        <th>نهاية الوقت</th>
                                        <th>نوع الوردية</th>
                                        <th>ملاحطات</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shifts as $index=>$shift)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $shift->user_id }}</td>
                                        <td>{{ $shift->start_cash }}</td>
                                        <td>{{ $shift->end_cash }}</td>
                                        <td>{{ $shift->start_time }}</td>
                                        <td>{{ $shift->end_time }}</td>
                                        <td>{{ $shift->getType() }}</td>
                                        <td>description</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                <x-dashboard.a-edit href="{{ route('products.edit', $shift->id) }}">
                                                </x-dashboard.a-edit>&nbsp;
                                                <form action="{{ route('products.destroy', $shift->id) }}"
                                                    method="POST">
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
                            {{ $shifts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection