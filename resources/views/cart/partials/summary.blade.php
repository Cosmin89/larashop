<table class="table">
    <tr>
        <td>Sub total</td>
        <td>$ {{ Cart::subtotal() }}</td>
    </tr>
    <tr>
        <td>Tax</td>
        <td>$ {{ Cart::tax() }}</td>
    </tr>
    <tr>
        <td class="success">Total</td>
        <td class="success">$ {{ Cart::total() }}</td>
    </tr>
</table>