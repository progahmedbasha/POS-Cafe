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
                                        <h4 class="card-title">تعديل واغلاق الوردية</h4>
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
                                            <input type="number" class="form-control" placeholder="استلام"
                                                name="start_cash" value="{{ $shift->start_cash }}" required />
                                            @error('start_cash')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">تسليم :</label>
                                            <input type="number" class="form-control" placeholder="تسليم"
                                                name="end_cash" value="{{ $shift->end_cash }}" required />
                                            @error('end_cash')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">نوع الورية :</label>
                                            <select class="form-control" name="type">
                                                <option value="">النوع</option>
                                                <option value="1" {{ $shift->type == '1' ? 'selected' : ''
                                                    }}>صباحي</option>
                                                <option value="2" {{ $shift->type == '2' ? 'selected' : ''
                                                    }}>مسائي</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="email">ملاحظات :</label>
                                            <textarea type="text" class="form-control" placeholder="ملاحظات"
                                                name="description" required>{{ $shift->description }}</textarea>
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