<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $attachment = [];
        $attachment[] = 'order_'.$this->data->id.'.pdf';
        foreach ($this->data->items as $item){
            //$view = view('client.order.warranty', ['order' => $this->data, 'item' => $item])->render();
            //$html = mb_convert_encoding($view, 'UTF-8', 'UTF-8');
            //$pdf = Pdf::loadHTML($html);
            $pdf = Pdf::loadView('client.order.warranty', ['order' => $this->data, 'item' => $item]);

            $file = 'warranty_'. $item->id .'.pdf';
            $pdf->save($file);
            $attachment[] = $file;
        }

        $this->view('client.order.order',['order' => $this->data]);

        foreach ($attachment as $file){
            $this->attach($file);
        }

        return $this;
    }
}
