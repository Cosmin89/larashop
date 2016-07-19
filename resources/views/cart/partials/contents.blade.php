<table class="table">
    @foreach(Cart::content() as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->qty }}</td>
        </tr>
    @endforeach
</table>