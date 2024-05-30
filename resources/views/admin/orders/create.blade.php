@extends('admin.layouts.master')
@section('content')
<!-- Nav Header Component Start -->
<br><br><br>
<!-- Nav Header Component End -->
<!--Nav End-->
</div>
{{-- content --}}
<div class="conatiner-fluid content-inner mt-n5 py-0">
   {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
   Open modal
   </button> --}}
   @if(Session::has('paymentshowdialog'))
   <script>
      $(function() {
          $('#myModal').modal('show');
      });
   </script>
   @endif
   {{-- @include('admin.classes.paymentmodal') --}}
   {{-- @if(Session::has('payment'))
   <script>
      $(function() {
          $('#PayModal').modal('show');
      });
   </script>
   @endif --}}
   {{-- @include('admin.classes.paymodal') --}}
   <div>
      <div class="row" style="justify-content: right;">
         {{-- 
         <div class="col-xl-5 col-lg-4">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">الطلاب المسجلين : </h4>
                  </div>
               </div>
               <hr class="hr-horizontal">
               <div class="card-body" style="max-height: 50%;">
                  <div class="table-responsive" style="max-height: 30%;">
                     <table id="user-list-table" class="table table-striped" role="grid">
                        <thead>
                           <tr class="ligth">
                              <th class="text-center">#</th>
                              <th>اسم الطالب</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($products as $index=>$product)
                           <tr>
                              <td class="text-center">{{ $index+1 }}</td>
                              <td>{{ $product->name }}</td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         --}}
         {{-- start card order --}}
         <form action="{{route('orders.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-xl-6 col-lg-8" style="padding-right: 0px;">
                  <div class="card">
                     <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                           <h4 class="card-title">تسجيل أوردر : #{{ $order_number }}</h4>
                        </div>
                     </div>
                     <hr class="hr-horizontal">
                     <div class="card-body">
                        <div class="new-user-info">
                           {{-- 
         <form action="{{route('orders.store')}}" method="post" enctype="multipart/form-data">
         @csrf --}}
         <input type="hidden" value="{{ $order_number }}" name="order_number">
         <div class="row">
         <div class="col">
         <label class="form-label" for="email">اسم العميل :</label>
         <select class="form-control" name="client_id">
         {{-- <option value="">العميل</option> --}}
         @foreach ($clients as $client)
         <option value="{{$client->id}}">
         {{$client->name}}
         </option>
         @endforeach
         </select>
         </div>
         <div class="col">
         <label class="form-label" for="email"> الطاولة :</label>
         <select class="form-control" name="table_id">
         <option value="">الطاولات</option>
         @foreach ($tabels as $table)
         <option value="{{$table->id}}" {{(old($table->id)==$table->id)?
         'selected':''}}>
         {{$table->name}}
         </option>
         @endforeach
         </select>
         </div>
         <div class="col">
         <label class="form-label" for="email"> الرومات :</label>
         <select class="form-control" name="room_id">
         <option value="">الرومات</option>
         @foreach ($rooms as $room)
         <option value="{{$room->id}}" {{(old($room->id)==$room->id)?
         'selected':''}}>
         {{$room->name}}
         </option>
         @endforeach
         </select>
         </div>
         </div>
         <div id="block">
         <div class="row">
         <div class="col">
         <label class="form-label" for="email">المنتج :</label><br>
         <select id="row_product_id" class="js-example-basic-multiple form-control"
            multiple="multiple" name="row_product_id[]" style="width: 275px;" />
         {{-- <option value="" disabled>المنتجــات</option> --}}
         @foreach ($products as $product)
         <option value="{{$product->id}}" {{(old($product->id)==$product->id)?
         'selected':''}}>
         {{$product->name}}
         </option>
         @endforeach
         </select>
         </div>
         <div class="col">
         <label class="form-label" for="email"> الكمية :</label>
         <input id="qty" type="number" min="1" class="form-control" placeholder="الكمية"
            name="qty" value="1" />
         </div>
         <div class="col">
         <label class="form-label" style="padding-bottom: 47px;"></label>
         <x-dashboard.a-create id="addbutton" onclick="addFunction()" style="    width: 99px;">
         </x-dashboard.a-create>
         </div>
         </div>
         <br>
         <div class="table-responsive" style="max-height: 30%;">
         {{-- <div id="duplicate">
         </div> --}}
         {{-- <div id="duplicate">
         </div> --}}
         </div>
         </div>
         <button type="submit" class="btn btn-primary">تسجيل أوردر</button>
         <hr>
         <textarea type="text" class="form-label" name="note"
            placeholder="اضافة ملاحظات للأوردر"></textarea>
         {{-- </form> --}}
         </div>
         </div>
         </div>
         </div>
         {{-- end card order --}}
         {{-- start card items --}}
         <div class="col-xl-6 col-lg-8" style="padding-right: 0px;">
         <div class="card">
         <div class="card-header d-flex justify-content-between">
         <div class="header-title">
         <h4 class="card-title">تفاصيل الأوردر : #{{ $order_number }}</h4>
         </div>
         </div>
         <hr class="hr-horizontal">
         <div class="card-body" style="padding-right: 0px;">
         <div id="duplicate">
         </div>
         </div>
         </div>
         </div>
         </div>
         </form>
         {{-- end card items --}}
      </div>
      <hr>
      <style>
         .table thead tr th {
         padding: 0.75rem 0.5rem;
         letter-spacing: -0.8px;
         }
      </style>
      <div class="row">
         <div class="col-xl-4 col-lg-4">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">الطاولات : </h4>
                  </div>
               </div>
               <hr class="hr-horizontal">
               <div class="card-body" style="max-height: 50%;">
                  <div class="table-responsive" style="max-height: 30%;">
                     <table id="user-list-table" class="table table-striped" role="grid">
                        <thead>
                           <tr class="ligth">
                              <th>الطاولة</th>
                              <th>الاجمالي</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($active_tables as $index=>$active_table)
                           <tr>
                              <td>طاولة : ( {{ $active_table->service->name }} )</td>
                              <td>{{ $active_table->orderItems->sum('total_cost') }}</td>
                              <td>
                                 <!-- Button trigger modal -->
                                 <button type="button" class="btn btn-sm btn-icon btn-success" title="عرض الفاتورة"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal{{$index}}">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                       <path
                                          d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z"
                                          stroke="currentColor"></path>
                                       <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>
                                       <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
                                       <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6"
                                          height="6">
                                          <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
                                       </mask>
                                       <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>
                                    </svg>
                                 </button>
                                 {{-- to print captin order  --}}
                                 <a href="#" class="btn btn-sm btn-icon btn-danger" style="font-size:xx-small;"
                                    onclick='openmodlePrintCaptinOrder("{{route("print_table_captin_order",["id" => $active_table->id] ) }}")'>Captin<br>Order
                                 </a>
                                 <a href="#" class="btn btn-sm btn-icon btn-danger"
                                    onclick='openmodle("{{route("print_table",["id" => $active_table->id] ) }}")'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="1em"
                                       viewBox="0 0 512 512">
                                       <path
                                          d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                                    </svg>
                                 </a>
                              </td>
                           </tr>
                           <!-- Unique Modal for Each Item -->
                           @include('admin.orders.modal_view_order')
                           @endforeach
                        </tbody>
                     </table>
                     <iframe id="iframe" src="" style="display:none;"></iframe>
                     <iframe id="iframeCaptinOrder" src="" style="display:none;"></iframe>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-8 col-lg-8">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">الرومات</h4>
                  </div>
               </div>
               <hr class="hr-horizontal">
               <div class="card-body">
                  <div class="table-responsive" style="max-height: 30%;">
                     <table id="user-list-table" class="table table-striped" role="grid">
                        <thead>
                           <tr class="ligth">
                              <th>الروم</th>
                              <th>بداية الوقت</th>
                              <th>وقت</th>
                              <th>سعر الوقت</th>
                              <th class="text-center">سعر المشروبات</th>
                              <th>الاجمالي</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($active_rooms as $index=>$active_room)
                           <tr>
                              <td>( {{ $active_room->service->name }} )</td>
                              <td>{{ date('h:i:s', strtotime($active_room->start_time)) }}</td>
                              {{-- 
                              <td>{{ $active_room->start_time->format('h:i:s') }}</td>
                              --}}
                              {{-- 
                              <td>{{ date('h:i:s', strtotime($active_room->start_time))  - date('h:i:s', strtotime($active_room->end_time))}}
                              </td>
                              --}}
                              <td>
                                 @if ($active_room->end_time != null)
                                 {{
                                 \Carbon\Carbon::parse($active_room->start_time)->diff(\Carbon\Carbon::parse($active_room->end_time))->format('%h:%i:%s')
                                 }}
                                 @endif
                              </td>
                              <td>
                                 @if ($active_room->end_time != null)
                                 @php
                                 $startTime = \Carbon\Carbon::parse($active_room->start_time);
                                 $endTime = \Carbon\Carbon::parse($active_room->end_time);
                                 $durationInSeconds = $startTime->diffInSeconds($endTime);
                                 $price = $active_room->service->ps_price;
                                 $totalPrice = $durationInSeconds ? intval(($durationInSeconds / 3600) * $price) : 0;
                                 @endphp
                                 {{ $totalPrice }} ج
                                 @endif
                              </td>
                              <td class="text-center">
                                 @if ($active_room->orderItems->count() > 0)
                                 {{ $active_room->orderItems->sum('total_cost') }} ج
                                 @else
                                 --
                                 @endif
                              </td>
                              @if ($active_room->orderItems->count() > 0 && $active_room->end_time != null)
                              <td>{{ $totalPrice + $active_room->orderItems->sum('total_cost')}} ج</td>
                              @else
                              <td>--</td>
                              @endif
                              <td>
                                 {{-- 
                                 <x-dashboard.a-show href="{{ route('orders.show', $active_room->id) }}"
                                    title="عرض الفاتورة ">
                                 </x-dashboard.a-show>
                                 --}}
                                 <button type="button" class="btn btn-sm btn-icon btn-success" title="عرض الفاتورة"
                                    data-bs-toggle="modal" data-bs-target="#roomModal{{$index}}">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                       <path
                                          d="M22.4541 11.3918C22.7819 11.7385 22.7819 12.2615 22.4541 12.6082C21.0124 14.1335 16.8768 18 12 18C7.12317 18 2.98759 14.1335 1.54586 12.6082C1.21811 12.2615 1.21811 11.7385 1.54586 11.3918C2.98759 9.86647 7.12317 6 12 6C16.8768 6 21.0124 9.86647 22.4541 11.3918Z"
                                          stroke="currentColor"></path>
                                       <circle cx="12" cy="12" r="5" stroke="currentColor"></circle>
                                       <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
                                       <mask mask-type="alpha" maskUnits="userSpaceOnUse" x="9" y="9" width="6"
                                          height="6">
                                          <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
                                       </mask>
                                       <circle opacity="0.89" cx="13.5" cy="10.5" r="1.5" fill="white"></circle>
                                    </svg>
                                 </button>
                                 <a href="{{ route('close_time', $active_room->id) }}"
                                    class="btn btn-sm btn-icon btn-warning">
                                 انهاء الوقت
                                 </a>
                                 {{-- to print captin order  --}}
                                 <a href="#" class="btn btn-sm btn-icon btn-danger" style="font-size:xx-small;"
                                    onclick='openmodlePrintCaptinOrder("{{route("print_table_captin_order",["id" => $active_room->id] ) }}")'>Captin<br>Order
                                 </a>
                                 @if ($active_room->end_time != null)
                                 <a href="#" class="btn btn-sm btn-icon btn-danger"
                                    onclick='openmodle("{{route("print_room",["id" => $active_room->id] ) }}")'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="1em"
                                       viewBox="0 0 512 512">
                                       <path
                                          d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                                    </svg>
                                 </a>
                                 @endif
                              </td>
                           </tr>
                           @include('admin.orders.modal_view_order_room')
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $(document).ready(function() {
   $('.js-example-basic-multiple').select2();
   });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   ////////////////////for fetch features////////////
   //    $(document).ready(function () {
   //       $('#addbutton').on('click', function () {
   //           $.ajax({
   //               type: "get",
   //              success:function(response){
   // 				      $('#block').append(response.result);
   //               },
   //           });
   //       });  	
   //   });
   // var currentRow = 0;
   //    function addRow() {
   //     currentRow++;
   //              $.ajax({
   //                  url: "{{route('add_row')}}",
   //                  type: "POST",
   //                  data: {
   //                      number:currentRow,
   //                      _token: '{{csrf_token()}}'
   //                  },
   //               success:function(response){
   // 				      $('#duplicate').append(response.result);
   //               },
   //              });
   //     }
   function addFunction() {
       var row_product_id = $('#row_product_id').val();
       var qty = $('#qty').val();
                $.ajax({
                    url: "{{route('add_row')}}",
                    type: "POST",
                    data: {
                        row_product_id:row_product_id,
                        qty:qty,
                        _token: '{{csrf_token()}}'
                    },
                 success:function(response){
                       $('#duplicate').html(response.result);
                       document.getElementById("block-table").style.display = "table";
                       // Empty the select input
                       $('#row_product_id').val(null).trigger('change');
                 },
                });
       }
   function openmodle(url){
       document.getElementById("iframe").src=url;
       setTimeout(function() {
           window.location.reload();
       }, 5000);
   }
   function openmodlePrintCaptinOrder(url){
       document.getElementById("iframeCaptinOrder").src=url;
   }
</script>
@endsection