<div class="form-group mb-3">
    <label for="name">Tên:</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $voucher->name ?? '') }}" required>
</div>
<div class="form-group mb-3">
    <label for="sale">Giảm giá (%):</label>
    <input type="number" name="sale" class="form-control" value="{{ old('sale', $voucher->sale ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label for="qty">Số lượng:</label>
    <input type="number" name="qty" class="form-control" value="{{ old('qty', $voucher->qty ?? '') }}" required>
</div>
<div class="form-group mb-3">
    <label for="point">Điểm:</label>
    <input type="number" name="point" class="form-control" value="{{ old('point', $voucher->point ?? '') }}" required>
</div>
<div class="form-group mb-3">
    <label for="start_date">Ngày bắt đầu:</label>
    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $voucher->start_date ?? '') }}" required>
</div>
<div class="form-group mb-3">
    <label for="end_date">Ngày kết thúc:</label>
    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $voucher->end_date ?? '') }}" required>
</div>
