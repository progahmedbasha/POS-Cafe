@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        الرومـــات
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        <x-slot:link>
            {{ route('rooms.create') }}
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
                            <h4 class="card-title">الرومـــات</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead>
                                    <tr class="ligth">
                                        <th class="text-center">#</th>
                                        <th>اسم الرووم</th>
                                        <th>السعر</th>
                                        <th>نوع الجهاز</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $index=>$room)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $room->name }}</td>
                                        <td>{{ $room->ps_price }}</td>
                                        <td>Ps {{ $room->ps_type }}</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                <x-dashboard.a-edit href="{{ route('rooms.edit', $room->id) }}">
                                                </x-dashboard.a-edit>&nbsp;
                                                <form action="{{ route('rooms.destroy', $room->id) }}"
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
                            {{ $rooms->links() }}
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