@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        المنتجــــــات
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
                            <h4 class="card-title">المنتجــــــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        {{-- search --}}
                        <form method="get" action="{{route('products.index')}}" style="padding: 20px;"
                            style="margin-left: 70%;">
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="البحث عن منتج"
                                        value="{{ request('search') }} " name="search" required />
                                </div>
                                <div class="col">
                                    <select class="form-control" name="category_id">
                                        <option value="">اختر التصنيف </option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">
                                            {{$category->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('products.index')}}"><span
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
                                        <th>التصنيف</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>صورة المنتج</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index=>$product)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category ? $product->category->name : '' }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            @if(!empty($product->photo))
                                            <img src="{{url($product->image)}}/{{$product->photo }}" class="w3-round"
                                                width="100px" height="100px" style="border-radius: 20px" alt="Norway">
                                            @else
                                            <img src="{{url('/data/error.png')}}" class="w3-round" width="100px"
                                                alt="Norway">
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                <x-dashboard.a-edit href="{{ route('products.edit', $product->id) }}">
                                                </x-dashboard.a-edit>&nbsp;
                                                <form action="{{ route('products.destroy', $product->id) }}"
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
                            {{ $products->links() }}
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