@if($products->count() > 0)
<table id="block-table" class="table table-striped" style="display:none;" role="grid">
    <thead>
        <tr class="ligth">
            <th class="text-center">#</th>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الاجمالي</th>
            <th>ملاحظة</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <input type="hidden" value="{{ $products->sum('price') }}" name="total_price">

        @foreach($products as $index=>$product)
        <tr>
            {{-- <td class="text-center">1</td> --}}
            <td> {{ $index + 1 }} <input type="hidden" name="product_id[]" value="{{ $product->product_id }}" /></td>
            <td>{{ $product->product->name }}</td>
            {{-- <td>{{ $product->qty }} <input type="hidden" value="{{ $product->qty }}" name="qty[]"></td> --}}
            <td><input type="text" min="1"  name="qty[]" data-id="{{ $product->id }}" style="width:50px" class="form-control qty"
                    autocomplete="off" value="{{ $product->qty }}"></td>
            {{-- <td>{{ $product->price }}</td> --}}
            <td> {{ $product->price }} <input type="hidden" class="item_price" value="{{ $product->price }}" /></td>
            <td class="price">{{ $product->total_cost }}</td>
            {{-- <td>
                <x-dashboard.delete-button type="button" data-id="{{ $product->id }}" class="btn btn-danger
            delete_order_item delete"></x-dashboard.delete-button>
            </td> --}}
            <td><input type="text"  name="row_note[]" value="{{ $product->note }}" class="form-control"></td>
            <td class="no-print"><button type="button" data-id="{{ $product->id }}"
                    class="btn btn-danger delete_order_item delete" style="padding: 0px;"><i
                        class="glyphicon glyphicon-trash"></i> <svg width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                        <path
                            d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg></button></td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif
<script>
    // delete item 
        $('.delete').click(function(){
                    $(this).closest('tr').remove();
                    $id_product = $(this).attr('data-id'); $id_product = $(this).attr('data-id');
                    $.ajax({
                            url: "{{route('sale_ajax_destroy')}}",
                            type: "Delete",
                            data: {
                                id_product: $id_product,
                                _token: '{{csrf_token()}}'
                            },

                                success:function(response){
                                    // $('#total_order').text(parseFloat($('#total_order').text()) - parseFloat(response.price));
                                    $('#total_order').text(parseFloat(parseFloat($('#total_order').text()) - parseFloat(response.price)).toFixed(2));
                                    // $('.total_qty').text(parseFloat($('.total_qty').text()) - parseFloat(response.qty));
                                }
                            });
                            
                            /** End Ajax Delete Roq **/
            });
    //
    // update qty 
      $('.qty').on('keyup', function () {
              var product_id = $(this).attr('data-id');
			  var qty = $(this).val();
			// var total_qty = $('.total_qty').text();
			var price = $(this).closest('tr').find('.item_price').val();
			//var price = $(this).find('.item-item_price').val();

				if(qty != ''){
					$.ajax({
                  url: "{{route('update_qty_ajax')}}",
                  type: "POST",
                  data: {
                      product_id: product_id,
					  qty: qty,
					//   total_qty:total_qty,
					  price:price,
                      _token: '{{csrf_token()}}'
                  },
				   context: this,
                 success:function(response){
					$(this).closest('tr').find('.price').text(response.total_price_item);
					var sum = 0;
						$('.price').each(function(){
							sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
						});
						$('#total_order').html(sum);
                        ///////////////////
                    $(this).closest('tr').find('.first_price').text(response.total_price_item);
					var sum = 0;
						$('.first_price').each(function(){
							sum += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
						});
						$('#total_order').html(sum);
                  },
              });
				}
          });
</script>