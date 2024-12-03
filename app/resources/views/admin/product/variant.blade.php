    @if($variants->isNotEmpty())
    <ul>
        @foreach ($variants as $variant)
            <li>{{ $variant->option_name }} - {{ $variant->option_value }}</li>
        @endforeach
    </ul>
@else
    <p>Không có dữ liệu cho lựa chọn này.</p>
@endif
