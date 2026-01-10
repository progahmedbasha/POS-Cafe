<div class="discount-box" data-order-id="{{ $active_room->id }}">

    <h6>الخصم</h6>

    <div class="row">
        <div class="col-6">
            <label>نوع الخصم</label>
            <select class="form-control discount_type">
                <option value="">بدون خصم</option>
                <option value="percent" {{ ($active_room->discount_type ?? '') === 'percent' ? 'selected' : '' }}>نسبة %</option>
                <option value="fixed" {{ ($active_room->discount_type ?? '') === 'fixed' ? 'selected' : '' }}>قيمة ثابتة</option>
            </select>
        </div>

        <div class="col-6">
            <label>قيمة الخصم</label>
            <input type="number" class="form-control discount_value" min="0" value="{{ $active_room->discount ?? 0 }}">
        </div>
    </div>

    <br>
     <h6 style="background-color: cornflowerblue;">
        الإجمالي بعد الخصم :
        @php
            $timePrice   = $active_room->orderTimes[0]->total_price ?? 0;
            $drinksPrice = $active_room->orderItems->sum('total_cost');
            $total       = $timePrice + $drinksPrice;

            $discount_type  = $active_room->discount_type ?? null;  // النوع
            $discount_value = $active_room->discount ?? 0;          // القيمة المدخلة

            // حساب الخصم حسب النوع
            if ($discount_type === 'percent') {
                $discountAmount = ($total * $discount_value) / 100;
            } elseif ($discount_type === 'fixed') {
                $discountAmount = $discount_value;
            } else {
                $discountAmount = 0;
            }

            if ($discountAmount > $total) {
                $discountAmount = $total;
            }

            $finalTotal = $total - $discountAmount;
        @endphp
        <span class="total_after_discount"
            data-time="{{ $timePrice }}"
            data-drinks="{{ $drinksPrice }}">
            {{ $finalTotal }} ج
        </span>
    </h6>
    <hr>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
let discountTimer = null;

$(document).on('change keyup', '.discount_type, .discount_value', function () {

    let box = $(this).closest('.discount-box');

    clearTimeout(discountTimer);
    discountTimer = setTimeout(function () {
        autoSaveDiscount(box);
    }, 400);
});

function autoSaveDiscount(box) {

    let orderId = box.data('order-id');

    let timePrice   = parseFloat(box.find('.total_after_discount').data('time'));
    let drinksPrice = parseFloat(box.find('.total_after_discount').data('drinks'));
    let total       = timePrice + drinksPrice;

    let type  = box.find('.discount_type').val();
    let value = parseFloat(box.find('.discount_value').val()) || 0;

    let discount = 0;

    if (type === 'percent') {
        discount = (total * value) / 100;
    } else if (type === 'fixed') {
        discount = value;
    }

    if (discount > total) discount = total;

    let finalTotal = total - discount;

    // عرض الإجمالي
    box.find('.total_after_discount')
       .text(finalTotal.toFixed(2) + ' ج');

    // Ajax حفظ
    $.ajax({
        url: "{{ route('orders.saveDiscount') }}",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            order_id: orderId,
            discount_type: type,
            discount_value: value,
            discount_amount: discount,
            final_total: finalTotal
        }
    });
}
</script>
