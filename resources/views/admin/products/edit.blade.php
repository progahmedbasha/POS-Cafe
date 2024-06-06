@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
       المنتجــــــات
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">المنتجــــــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">تعديل المنتج</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac
                                        venenatis mollis, diam nibh finibus leo</p> --}}
                                    <form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                            <label class="form-label" for="email">اسم المنتج :</label>
                                            <input type="text" class="form-control" placeholder="الاسم" name="name"
                                                value="{{ $product->name }}" required />
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email"> الكمية :</label>
                                            <input type="text" class="form-control" placeholder="الاسم" name="qty"
                                                value="{{ $product->qty }}" required />
                                            @error('qty')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">السعر :</label>
                                            <input type="text" class="form-control" placeholder="الاسم" name="price"
                                                value="{{ $product->price }}" required />
                                            @error('price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">التصنيف :</label>
                                            <select class="form-control" name="category_id">
                                                <option value="">اختر تصنيف</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}" {{($product->category_id ==
                                                    $category->id)?'selected':''}}>
                                                    {{$category->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">صورة المنتج :</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="file" class="form-control" name="photo"
                                                        accept="image/*">
                                                </div>
                                                <div class="col-3">
                                                    @if(!empty($product->photo))
                                                    <img src="{{url($product->image)}}/{{$product->photo }}"
                                                        class="w3-round" width="100px" alt="Norway">
                                                    @else
                                                    <img src="{{url('/data/error.png')}}" class="w3-round" width="100px"
                                                        alt="Norway">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">حفظ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection