<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Excel;
use App\Order;

class ExportController extends Controller
{
    public function exportOrders(){
        $today = new \Datetime();
        $onemonth = new \DateInterval('P1M');
        $today_formatted = $today->format('Y-m-d');
        $monthago_formatted = $today->sub($onemonth)->format('Y-m-d');
        
        $orders = Order::where('created_at', '>=', $monthago_formatted)->where('created_at', '<=', $today_formatted)->get();
        
        $per_order = [];
        $per_product = [];
        foreach($orders as $order){
            // basket & basket item list
            $basket = json_decode($order->basket, true);
            
            // sheet: per order
            $total = 0; // total to add on to
            $items = ''; // items to append to
            
            // basket rows
            foreach($basket as $row){
                $items = $items . ', ' . $row['name'];
                $total = $total + $row['subtotal'];
            }
            
            // build the order row and push onbto the array
            $thisorder = [
                'orderid' => $order->orderid,
                'placed_by' => $order->name,
                'email' => $order->email,
                'company' => $order->company,
                'date' => $order->created_at,
                'total' => number_format($total, 2),
                'items' => substr($items, 2), // remove leading comma
            ];
            array_push($per_order, $thisorder);
            
            foreach($basket as $row){
                $thisproduct = [
                    'orderid' => $order->orderid,
                    'placed_by' => $order->name,
                    'email' => $order->email,
                    'company' => $order->company,
                    'date' => $order->created_at,
                    'qty' => $row['qty'],
                    'total' => number_format($row['subtotal'], 2),
                    'item' => $row['name'],
                ];
                array_push($per_product, $thisproduct);
            }
        }
        
        $file = \Excel::create('SMMEX_' . $monthago_formatted . '-' . $today_formatted, function($excel) use($per_order, $per_product){
            $excel->sheet('per_product', function($sheet) use($per_product){
               $sheet->fromArray($per_product);
            });
            $excel->sheet('per_order', function($sheet) use($per_order){
               $sheet->fromArray($per_order);
            });
        })->store('xlsx', false, true);
        
        $view_data = [];
        $email_data = [
            'email' => env('REPORT_EMAIL'),
        ];
        
        \Mail::send('emails.report', $view_data, function($message) use($email_data, $file) {
            $message->to($email_data['email'])
                    ->subject('SMMEX Order Report')
                    ->attach($file['full']);
        });
        
        return 'done';
    }
    
    public function lloydExport(){
        $orders = Order::all();
        
        $array = [];
        foreach($orders as $order){
            $thisOrder['orderid'] = $order->orderid;
            $thisOrder['name'] = $order->name;
            $thisOrder['email'] = $order->email;
            $thisOrder['company'] = $order->company;
            $thisOrder['created_at'] = $order->created_at;
            
            $thisOrderBasket = json_decode($order->basket, true);
            $basketItems = '';
            foreach($thisOrderBasket as $row){
                $basketItems = $basketItems . ', ' . $row['name'];
                $thisOrder['items'] = substr($basketItems, 2);
            }
                
            array_push($array, $thisOrder);
        }
        
        
        $file = \Excel::create('SMMEX_export', function($excel) use($array){
            $excel->sheet('orders', function($sheet) use($array){
               $sheet->fromArray($array);
            });
        })->export('xlsx');
    }
}
