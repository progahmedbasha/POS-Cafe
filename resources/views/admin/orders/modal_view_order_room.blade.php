<!-- Modal -->
<div class="modal fade" id="roomModal{{$index}}" tabindex="-1" aria-labelledby="roomModalLabel{{$index}}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roomModalLabel{{$index}}">رووم : ({{ $active_room->service->name }})
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Modal Body Content -->
                <style>
                    #grid {
                        display: grid;
                        grid-template-columns: 30% 15% 20% 20% 5%;
                        /* Adjusted to four columns */
                        gap: 10px;
                        /* Optional: Add some gap between grid items */
                    }

                    #grid div {
                        padding: 10px;
                        border: 1px solid #ccc;
                        /* Optional: Add border for better visibility */
                    }
                </style>

                <div id="grid">
                    <!-- Grid Header -->
                    <div><strong>المنتج</strong></div>
                    <div><strong>الكمية</strong></div>
                    <div><strong>السعر</strong></div>
                    <div><strong>الاجمالي</strong></div>
                    <div>-</div>

                    <!-- Grid Items -->
                    @foreach($active_room->orderItems as $index=>$item)
                    <div>{{ $item->product->name }}</div>
                    <div>{{ $item->qty }}</div>
                    <div>{{ $item->price }}</div>
                    <div>{{ $item->total_cost }}</div>
                    {{-- <div> --}}
                    <button type="button" data-id="{{ $item->id }}" class="btn btn-danger delete_item"
                        style="padding: 0px;"><i class="glyphicon glyphicon-trash"></i> <svg width="20"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                            <path
                                d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                            <path
                                d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </svg>
                    </button>
                    {{-- </div> --}}
                    @endforeach
                </div>
                <br>
                @if ($active_room->orderItems->count() > 0)
                اجمالي المشروبات : 
                {{ $active_room->orderItems->sum('total_cost') }} ج
                @endif
                <hr>
                <h6>بداية الوقت : {{ date('h:i:s', strtotime($active_room->start_time)) }}</h6>
                <h6>الوقت :
                    @if ($active_room->end_time != null)
                    {{\Carbon\Carbon::parse($active_room->start_time)->diff(\Carbon\Carbon::parse($active_room->end_time))->format('%h:%i:%s')}}
                    @endif
                </h6>
                <h6>سعر الوقت : @if ($active_room->end_time != null)
                    @php
                    $startTime = \Carbon\Carbon::parse($active_room->start_time);
                    $endTime = \Carbon\Carbon::parse($active_room->end_time);
                    $durationInSeconds = $startTime->diffInSeconds($endTime);
                    $price = $active_room->service->ps_price;
                    $totalPrice = $durationInSeconds ? intval(($durationInSeconds / 3600) * $price) : 0;
                    @endphp
                    {{ $totalPrice }} ج
                    @endif
                </h6>
                <hr>
                <h6> 
                    @if ($active_room->orderItems->count() > 0 && $active_room->end_time != null)
                    <h6>المبلغ الاجمالي : {{ $totalPrice + $active_room->orderItems->sum('total_cost')}} ج</h6>
                    @else
                    <h6>--</h6>
                    @endif
                </h6>

            </div>
            <div class="modal-footer">
                <form action="{{ route('change_table', $active_table->id)}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="table_id">
                                <option value="">الطاولات</option>
                                @foreach ($tabels as $table)
                                <option value="{{$table->id}}" {{($active_table->service_id==$table->id)?
                                    'selected':''}}>
                                    {{$table->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">نقل</button>
                        </div>
                    </div>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
<script>
    // delete item 
        $('.delete_item').click(function(){
            // console.log('ssd');
                    $(this).closest('tr').remove();
                    $item_id = $(this).attr('data-id'); $item_id = $(this).attr('data-id');
                    $.ajax({
                            url: "{{route('item_ajax_destroy')}}",
                            type: "Delete",
                            data: {
                                item_id: $item_id,
                                _token: '{{csrf_token()}}'
                            },

                                success:function(response){
                                    location.reload();
                                }
                            });
                            
                            /** End Ajax Delete Roq **/
            });
    //
</script>