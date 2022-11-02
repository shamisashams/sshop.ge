<table>
    <tr>
        <td colspan="2">
            id#:{{$order->id}}
        </td>
        <td colspan="2">
            date#:{{$order->created_at}}
        </td>

    </tr>
    <tr>
        <th class="wd-20p">Product</th>

        <th class="tx-center">QNTY</th>
        <th class="tx-right">Unit</th>
        <th class="tx-right">Amount</th>
    </tr>
    @foreach($order->items as $item)
        <tr>
            <td>{{$item->name}}</td>

            <td class="tx-center">{{$item->qty_ordered}}</td>
            <td class="tx-right">{{$item->price}}₾</td>
            <td class="tx-right">{{$item->total}}₾</td>
        </tr>
    @endforeach

    @foreach($order->collections as $item)
        <tr>
            <td>Furniture-set: {{$item->title}}<br>
                Color: {{$item->items[0]->attributes->color}}
            </td>

            <td>
                <table>
                    <tr>
                        <th>product</th>
                        <th>price</th>
                    </tr>
                    @foreach($item->items as $prod)
                        <tr>
                            <td>
                                {{$prod->title}}
                            </td>
                            <td>
                                {{$prod->price}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>

            <td class="tx-right">{{$item->price}}₾</td>
            <td class="tx-right">{{$item->total_price}}₾</td>
        </tr>
    @endforeach

    <tr>
        <td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
        <td class="tx-right" colspan="2">
            <h4 class="tx-bold">{{$order->grand_total}}₾</h4>
        </td>
    </tr>
    <tr>
        <td class="tx-right tx-uppercase tx-bold tx-inverse">Sipping</td>
        <td class="tx-right" colspan="2">
            <h4 class="tx-bold">{{$order->ship_price}}₾</h4>
        </td>
    </tr>
</table>
