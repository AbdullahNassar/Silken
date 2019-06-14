<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use DB;
use App\Category;
use Carbon\Carbon;

class OrderController extends Controller {

    /**
    * Render the all products pages.
    *
    * @return View
    */
    public function getIndex() {
        $orders = Order::latest()->paginate(15);
        if(request()->ajax()){
            return view('admin.pages.orders.templates.orders-table',compact('orders'))->render();
        }
        return view('admin.pages.orders.index',compact('orders'));
    }

    public function postApprove($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return  [
                'status' => 'warning',
                'title' => 'Warning',
                'msg' => 'Changes have been failed, No order with ID #'.$order_id,
            ];
        }

        $this->_action($order_id, 'approved');

        return  [
            'status' => 'success',
            'title' => 'Success',
            'msg' => 'Changes have been applied successfully',
            'element' => '#ajax-table',
            'html' => view('admin.pages.orders.templates.orders-table',['orders' => Order::latest()->paginate(15)])->render()
        ];
    }

    public function postCancel($order_id)
    {

        $order = Order::find($order_id);
        if (!$order) {
            return  [
                'status' => 'warning',
                'title' => 'Warning',
                'msg' => 'Changes have been failed, No order with ID #'.$order_id,
            ];
        }

        $this->_action($order_id, 'canceled');

        return  [
            'status' => 'success',
            'title' => 'Success',
            'msg' => 'Changes have been applied successfully',
            'element' => '#ajax-table',
            'html' => view('admin.pages.orders.templates.orders-table',['orders' => Order::latest()->paginate(15)])->render()
        ];
    }

    public function postAction($action, Request $r) {
        $state = '';
        switch ($action) {
            case 'pending':
            $state = 'pending';
            break;
            case 'approved':
            $state = 'approved';
            break;
            case 'canceled':
            $state = 'canceled';
            break;
            default :
            $data = [
                'status' => 'warning',
                'title' => trans('msgs.error.edit.title'),
                'msg' => trans('admin_global.msg_action_not_supported'),
            ];
            return $data;
        }

        if ($r->has('ids')) {
            $ids = $r->input('ids');
            foreach ($ids as $id) {
                $this->_action($id, $state);
            }
            $data =    [
                'status' => 'success',
                'title' => 'Success',
                'msg' => 'Changes have been applied successfully',
            ];
        } else {
            $data = [
                'status' => 'warning',
                'title' => trans('msgs.error.edit.title'),
                'msg' => trans('admin_global.msg_mark_at_least'),
            ];
        }

        return $data;
    }

    protected function _action($id, $state) {
        $order = Order::find($id);

        $order->status = $state;

        $order->save();
    }

    public function getFilter($filter) {
        $orders = Order::latest();
        $orders = $this->_filter($orders, $filter)->paginate(15);
        return view('admin.pages.orders.templates.orders-table',compact('orders'))->render();
    }

    protected function _filter(&$orders, $filter) {
        switch ($filter) {
            case 'all':
            return $orders;
            case 'pending':
            return $orders->where('status', 'pending');
            case 'approved':
            return $orders->where('status', 'approved');
            case 'canceled':
            return $orders->where('status', 'canceled');
        }
    }

    public function getDelete($id) {
        $order = Order::find($id);

        if(!$order){
            return back()->withWarning(trans('products.id_not_found',['id' => $id]));
        }

        $order->trash();

        return back()->withSuccess(msg('success.delete.msg'));
    }
}
