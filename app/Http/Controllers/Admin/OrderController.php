<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrderController extends Controller
{

    private $orderRepository;



    public function __construct(
        OrderRepository $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * @param SettingRequest $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        /*return view('admin.pages.setting.index', [
            'settings' => $this->settingRepository->getData($request, ['translations'])
        ]);*/

        return view('admin.nowa.views.order.index', [
            'orders' => $this->orderRepository->getData($request,['items'])
        ]);
    }


    /**
     * @param string $locale
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function show(string $locale, Order $order)
    {
        return view('admin.nowa.views.order.show', [
            'order' => $order,
        ]);
    }



    public function edit(string $locale, Order $order)
    {
        $url = locale_route('order.update', $order->id, false);
        $method = 'PUT';

        /*return view('admin.pages.setting.form', [
            'setting' => $setting,
            'url' => $url,
            'method' => $method,
        ]);*/

        return view('admin.nowa.views.order.form', [
            'order' => $order,
            'url' => $url,
            'method' => $method,
        ]);
    }



    public function update(Request $request,string $locale, Order $order)
    {
        $saveData = Arr::except($request->except('_token'), []);
        $this->orderRepository->update($order->id,$saveData);


        return redirect(locale_route('order.index', $order->id))->with('success', __('admin.update_successfully'));
    }


    public function setActive(Request $request){
        //dd($request->all());
        Setting::where('id',$request->get('id'))->update(['active' => $request->get('active')]);
    }


    public function export(Request $request){

        //dd($request->all());
        $query = Order::query();
        if($request->get('from')){

            $query->whereDate('created_at', '>=',$request->get('from'));
        }
        if($request->get('to')){
            //dd(4);
            $query->whereDate('created_at', '<=',$request->get('to'));
        }

        $orders = $query->get();

        //dd($orders);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Orders");
        $i = 2;
        $sheet->setCellValue("A1", 'id');
        $sheet->setCellValue("B1", 'name');
        $sheet->setCellValue("C1", 'email');
        $sheet->setCellValue("D1", 'phone');
        $sheet->setCellValue("E1", 'grand total');
        foreach ($orders as $order){
            $sheet->setCellValue("A".$i, $order["id"]);
            $sheet->setCellValue("B".$i, $order["name"]);
            $sheet->setCellValue("C".$i, $order["email"]);
            $sheet->setCellValue("D".$i, $order["phone"]);
            $sheet->setCellValue("E".$i, $order["grand_total"]);
            $i++;
        }
        //dd($spreadsheet);
        $writer = new Xlsx($spreadsheet);
        $writer->save("orders.xlsx");

        return response()->download('orders.xlsx');

    }
}
