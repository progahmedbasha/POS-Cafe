@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        الورديات
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
                            <h4 class="card-title">الورديات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">اضافة وردية جديده</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac
                                        venenatis mollis, diam nibh finibus leo</p> --}}
                                    <form action="{{route('shifts.store')}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label" for="email">استلام :</label>
                                            <input type="number" class="form-control" placeholder="استلام" name="start_cash"
                                                value="{{ old('start_cash') }}" required />
                                            @error('start_cash')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">نوع الورية :</label>
                                            <select class="form-control" name="type">
                                                <option value="">النوع</option>
                                                <option value="1" {{ old('type') == '1' ? 'selected' : ''
                                                    }}>صباحي</option>
                                                <option value="2" {{ old('type') == '2' ? 'selected' : ''
                                                    }}>مسائي</option>
                                                    <option value="3" {{ old('type') == '3' ? 'selected' : ''
                                                    }}>الادارة</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">ملاحظات :</label>
                                            <textarea type="text" class="form-control" placeholder="ملاحظات" name="description"
                                                >{{ old('description') }}</textarea>
                                            @error('description')
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