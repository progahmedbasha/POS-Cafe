@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<x-dashboard.base.nav>
    <x-slot:heading>
        العمــلاء
        </x-slot>
        {{-- We are on a mission to help developers like you build successful projects for FREE. --}}
        <x-slot:link>
            {{ route('clients.create') }}
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
                            <h4 class="card-title">العمــلاء</h4>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped" role="grid">
                                <thead>
                                    <tr class="ligth">
                                        <th class="text-center">#</th>
                                        <th>اسم العميل</th>
                                        <th>التليفون</th>
                                        <th>عدد مرات الشراء </th>
                                        <th>العنوان</th>
                                        <th style="min-width: 100px">الإعدادات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $index=>$client)
                                    <tr>
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>{{ $client->orders_count }}</td>
                                        <td>Ps {{ $client->address }}</td>
                                        <td>
                                            <div class="flex align-items-center list-user-action"
                                                style="display: flex;">
                                                <x-dashboard.a-edit href="{{ route('clients.edit', $client->id) }}">
                                                </x-dashboard.a-edit>&nbsp;
                                                <form action="{{ route('clients.destroy', $client->id) }}"
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
                            {{ $clients->links() }}
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