@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        المصروفـــات
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        <x-slot:link>
            {{ route('expenses.create') }}
            </x-slot>
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
                            <h4 class="card-title">المصروفـــات</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row g-2 align-items-end">

                            <!-- من تاريخ -->
                            <div class="col-md-2">
                                <label class="form-label">من تاريخ</label>
                                <input type="date" name="from_date" class="form-control"
                                    value="{{ request('from_date') }}">
                            </div>

                            <!-- إلى تاريخ -->
                            <div class="col-md-2">
                                <label class="form-label">إلى تاريخ</label>
                                <input type="date" name="to_date" class="form-control"
                                    value="{{ request('to_date') }}">
                            </div>

                            <!-- الوردية -->
                            <div class="col-md-2">
                                <label class="form-label">الوردية</label>
                                <select name="shift_id" class="form-control">
                                    <option value="">اختر الوردية</option>
                                    @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ request('shift_id') == $shift->id ? 'selected' : '' }}>
                                            {{ $shift->getType() }} - {{ $shift->user->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- زر -->
                            <div class="col-md-4" style=" margin-top: 30px !important;">
                                <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="16" height="16" fill="currentColor" class="bi bi-search"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </button>
                                <a class="btn btn-danger" href="{{ route('expenses.index')}}"><span
                                        aria-hidden="true">&times;</span></a>
                            </div>

                        </form>
                    </div>

                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead>
                                    <tr class="ligth">
                                        <th class="text-center">#</th>
                                        <th>الوردية</th>
                                        <th>المبلغ</th>
                                        <th>السبب</th>
                                        <th>التاريخ</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $index=>$expense)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $expense->shift->getType() }} - {{ $expense->user->name }}</td>
                                        <td>{{ $expense->price }}</td>
                                        <td>{{ $expense->note ? $expense->note : '' }}</td>
                                        <td> {{ $expense->created_at }} </td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                <x-dashboard.a-edit href="{{ route('expenses.edit', $expense->id) }}">
                                                </x-dashboard.a-edit>&nbsp;
                                                <form action="{{ route('expenses.destroy', $expense->id) }}"
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
                            {{ $expenses->links() }}
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