@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        الرومـــات
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
                            <h4 class="card-title">الرومـــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">تعديل الروم</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac
                                        venenatis mollis, diam nibh finibus leo</p> --}}
                                    <form action="{{route('rooms.update', $service->id)}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <div class="form-group">
                                            <label class="form-label" for="email">اسم المنتج :</label>
                                            <input type="text" class="form-control" placeholder="الاسم" name="name"
                                                value="{{ $service->name }}" required />
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email"> السعر :</label>
                                            <input type="text" class="form-control" placeholder="الاسم" name="ps_price"
                                                value="{{ $service->ps_price }}" required />
                                            @error('ps_price')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">نوع الجهاز :</label>
                                            <select class="form-control" name="ps_type">
                                                <option value="">الجهاز</option>
                                                <option value="4" {{ $service->ps_type == '4' ? 'selected' : ''
                                                    }}>Ps 4</option>
                                                <option value="5" {{ $service->ps_type == '5' ? 'selected' : ''
                                                    }}>Ps 5</option>

                                            </select>
                                            @error('ps_type')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
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