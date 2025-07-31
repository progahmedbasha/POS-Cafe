<!-- Modal -->
<div class="modal fade" id="exampleModal{{$index}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$index}}"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel{{$index}}">طاولة : ({{ $active_table->service->name }})
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
                    @foreach($active_table->orderItems as $index=>$item)
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
                {{-- <hr> --}}
                <br>
                @if ($active_table->orderItems->count() > 0)
                اجمالي المشروبات :
                {{ $active_table->orderItems->sum('total_cost') }} ج
                @endif
                <hr>
                @if (!empty($active_table->orderTimes[0]->start_time))
                <h6>بداية الوقت : {{ date('h:i:s', strtotime($active_table->orderTimes[0]->start_time)) }}</h6>
                <h6>الوقت :
                    @if ($active_table->orderTimes[0]->end_time != null)
                    {{\Carbon\Carbon::parse($active_table->orderTimes[0]->start_time)->diff(\Carbon\Carbon::parse($active_table->orderTimes[0]->end_time))->format('%h:%i:%s')}}
                    @endif
                </h6>
                <h6>سعر الوقت : @if ($active_table->orderTimes[0]->end_time != null)
                    {{ $active_table->orderTimes[0]->total_price }}
                    @endif
                </h6>
                <hr>
                <h6>
                    @if ($active_table->orderItems->count() > 0 && $active_table->orderTimes[0]->end_time != null)
                    <h6>المبلغ الاجمالي :
                        {{ $active_table->orderTimes[0]->total_price + $active_table->orderItems->sum('total_cost')}} ج
                    </h6>
                    @else
                    <h6>--</h6>
                    @endif
                </h6>
                @endif

                <hr>
                <div style="background-color: blanchedalmond;">
                    <form action="{{route('orders.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="add_water" name="add_water">
                        <input type="hidden" value="{{ $active_table->order_number }}" name="order_number">
                        <input type="hidden" value="{{ $active_table->id }}" name="table_id">
                        <input type="hidden" value="{{ $active_table->client_id }}" name="client_id">
                        <input type="hidden" value="{{ $active_table->service_id }}" name="table_id">
                        <input type="hidden" name="total_price" value="8">
                        <div class="row" style="margin-right: 1px;">
                            <div class="col">
                                <label class="form-label">اضافة مياه</label>
                                <select class="form-control" name="product_id[]">
                                    <option value="186" selected>مياه</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">الكمية</label>
                                <input type="number" class="form-control" value="1" name="qty[]" min="1">
                            </div>
                            <div class="col" style="margin-top: 32px;">
                                <button type="submit" class="btn btn-primary form-control" style="width: auto;">اضافة</button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
    <!-- start sending whatsapp -->
    @php
        // تجهيز رقم الهاتف بشكل صحيح (بدون صفر وبدون +)
        $cleanPhone = ltrim($active_table->client->phone, '0');
        $clientPhone = '20' . $cleanPhone;

        $message = "🧾 *رقم الفاتورة :* " . $active_table->number . "\n";
        $message .= "📍 *الخدمة:* " . $active_table->service->name . "\n";
        $message .= "--------------------------\n";

        // تفاصيل الطلبات (المشروبات)
        if ($active_table->orderItems->count() > 0) {
            foreach ($active_table->orderItems as $item) {
                $product = $item->product->name ?? '---';
                $qty = $item->qty;
                $total = $item->total_cost;
                $message .= "• $product x$qty = $total \n";
            }
            $message .= "--------------------------\n";
            $drinksTotal = $active_table->orderItems->sum('total_cost');
            $message .= "🥤 *إجمالي المشروبات:* $drinksTotal ج\n";
        }

        // وقت الوقت
        $timeStarted = $active_table->orderTimes[0]->start_time ?? null;
        $timeEnded = $active_table->orderTimes[0]->end_time ?? null;
        $timePrice = $active_table->orderTimes[0]->total_price ?? 0;

        if (!empty($timeStarted)) {
            $message .= "🕐 *بداية الوقت:* " . date('h:i:s A', strtotime($timeStarted)) . "\n";

            if (!empty($timeEnded)) {
                $diff = \Carbon\Carbon::parse($timeStarted)->diff(\Carbon\Carbon::parse($timeEnded));
                $duration = $diff->format('%h:%I:%S');
                $message .= "⏱️ *مدة الوقت:* $duration\n";
                $message .= "💸 *سعر الوقت:* $timePrice ج\n";
            }
        }

        // إجمالي المبلغ
        if ($active_table->orderItems->count() > 0 && $timeEnded) {
            $grandTotal = $timePrice + $drinksTotal;
            $message .= "--------------------------\n";
            $message .= "💰 *الإجمالي:* $grandTotal ج\n";
        }
        $message .= "--------------------------\n";
        $message .= $whats_msg;
        // تشفير الرسالة
        $encodedMessage = urlencode($message);
        $waLink = "https://wa.me/$clientPhone?text=$encodedMessage";
    @endphp

    <a href="{{ $waLink }}" target="_blank" class="btn btn-success" title="إرسال على واتساب">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
    <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
    </svg>
    </a>
    <!-- end sending whatsapp -->

                <form action="{{ route('change_table', $active_table->id)}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="table_id">
                                <option value="">الطاولات</option>
                                @foreach ($services as $service)
                                <option value="{{$service->id}}" {{($active_table->service_id==$service->id)?
                                    'selected':''}}>
                                    {{$service->name}}
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