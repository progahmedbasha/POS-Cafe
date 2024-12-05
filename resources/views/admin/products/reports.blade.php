@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        تقارير المنتجــات
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        <x-slot:link>
            {{ route('products.create') }}
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
                            <h4 class="card-title">تقارير المنتجــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        {{-- search --}}
                        <form method="get" action="{{route('product-reports')}}" style="padding: 20px;"
                            style="margin-left: 70%;">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">المنتج</label>
                                    <input type="text" class="form-control" placeholder="البحث عن منتج"
                                        value="{{ request('search') }}" name="search" />
                                </div>
                                <div class="col">
                                    <label class="form-label">عرض من تاريخ</label>
                                    <input type="date" class="form-control" name="from"
                                        value="{{ request('from') }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">الي تاريخ</label>
                                    <input type="date" class="form-control" name="to"
                                        value="{{ request('to') }}">
                                </div>
                               <div class="col">
                                    <label class="form-label">الوردية</label>
                                    <select class="form-control" name="shift_id">
                                        <option value=""> الورديات </option>
                                        @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}"
                                            {{ request('shift_id') == $shift->id ? 'selected' : '' }}
                                            {{ $shift->status == 1 ? 'style=background-color:green' : '' }}>
                                             {{ $shift->status == 1 ? ' (الحالية)' : '' }} -  {{ $shift->getType() }} - {{ $shift->user->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4" style=" margin-top: 30px !important;">
                                    <button type="submit" class="btn btn-primary"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('product-reports')}}"><span
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
                                        <th>اسم المنتج</th>
                                        <th>غدد مرات البيع</th>
                                        <th>اجمالي الفواتير</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->totalQty_shift }}</td>
                                        <td>{{ $product->totalCost_shift }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $products->withQueryString()->links() }} --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Initialize DataTable -->
<script>
    $(document).ready(function() {
        $('#user-list-table').DataTable({
            "paging": true, // Enable pagination
            "searching": false, // Enable search
            "lengthChange": false, // Disable page length change (optional)
            "info": true, // Enable info display
            "language": {
                "paginate": {
                    "previous": "السابق",
                    "next": "التالي"
                },
                "search": "بحث:",
                "lengthMenu": "عرض _MENU_ سجلات",
                "info": "إظهار _START_ إلى _END_ من إجمالي _TOTAL_"
            }
        });
    });
</script>
@endsection