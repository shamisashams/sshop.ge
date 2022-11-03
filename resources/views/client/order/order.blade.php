<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sshop Order</title>
    <style></style>
  </head>
  <body style="font-family: sans-serif">
    <div style="max-width: 1300px; margin: auto; padding: 20px">
      <h1>Order id #{{$order->id}}</h1>
      <p style="margin: 6px 0">{{$order->first_name}} {{$order->last_name}}</p>
      <p style="margin: 6px 0">Tel: {{$order->phone}}</p>
      <p style="margin: 6px 0">{{$order->city}}</p>
      <p style="margin: 6px 0">{{$order->address}}</p>
      <p style="margin: 6px 0">{{$order->info}}</p>

      <div style="margin: 30px 0">
        <p style="margin: 6px 0"><strong>Payment Method > </strong> {{$order->payment_method ? 'Bank' : 'Cash'}}</p>
        <p style="margin: 6px 0"><strong>Shipping Price > </strong> {{$order->ship_price}}</p>
      </div>
      <div style="width: 100%; overflow-x: scroll">
        <table style="border-collapse: collapse; width: 100%">
          <tr>
            <th
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: left;
              "
            >
              Product
            </th>
            <th style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 10px">
              QNTY
            </th>
            <th style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 10px">
              Unit
            </th>
            <th style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 10px">
              Amount
            </th>
          </tr>
            @foreach($order->items as $item)
                <tr>
                    <td style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 10px">
                        {{$item->name}} {{$item->model}}
                    </td>
                    <td
                        style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
                    >
                        {{$item->qty_ordered}}
                    </td>
                    <td
                        style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
                    >
                        {{$item->price}}GEL
                    </td>
                    <td
                        style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
                    >
                        {{$item->total}}GEL
                    </td>
                </tr>
            @endforeach
          {{--<tr>
            <td style="border: 1px solid rgba(0, 0, 0, 0.1); padding: 10px">
              ასჯჰფბს ksjnfoisef
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              1
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              939.00₾
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              939.00₾
            </td>
          </tr>--}}
          <tr>
            <td
              colspan="2 "
              rowspan="4"
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                min-width: 300px;
              "
            >
              Notes
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              Sub- total
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
                {{$order->grand_total}}GEL
            </td>
          </tr>
          <tr>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              Tax
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              0%
            </td>
          </tr>
          <tr>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              Discount
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
                {{$order->discount ?? 0}}%
            </td>
          </tr>
          <tr>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              Shipping
            </td>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
                {{$order->ship_price}}GEL
            </td>
          </tr>
          <tr>
            <td
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
                text-transform: uppercase;
              "
            >
              Total Due
            </td>
            <td
              colspan="3"
              style="
                border: 1px solid rgba(0, 0, 0, 0.1);
                padding: 20px;
                text-align: center;
              "
            >
              <h2>{{$order->grand_total + $order->ship_price}}GEL</h2>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
