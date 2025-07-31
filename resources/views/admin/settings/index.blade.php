@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        الاعدادات
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
                            <h4 class="card-title">الاعدادات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <!-- <h4 class="card-title">اضافة عميل جديد</h4> -->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('settings.update') }}">
                                        @csrf
                                        <div class="card-body">
                                            @foreach ($messages as $message)
                                                <div class="mb-3">
                                                    <label for="setting_{{ $loop->index }}" class="form-label">{{ $message->key }}</label>
                                                    <textarea 
                                                        name="settings[{{ $message->key }}]" 
                                                        id="setting_{{ $loop->index }}" 
                                                        class="form-control" 
                                                        rows="3">{{ $message->value }}</textarea>
                                                </div>
                                            @endforeach
                                            <button type="submit" class="btn btn-primary">حفظ الكل</button>
                                        </div>
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