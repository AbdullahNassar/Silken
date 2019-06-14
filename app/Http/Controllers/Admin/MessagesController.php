<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Carbon\Carbon;

class MessagesController extends Controller
{
    //
    public function getIndex() {
        $messages = Message::get();

        return view('admin.pages.messages.index', compact('messages'));
    }

    //filters
    public function getSearch($q = null) {

        if (!empty($q)) {
            $cols = (new Message())->getTableColumns();
            $messages = Message::latest();
            $messages->where('id', 'LIKE', "%$q%");
            foreach ($cols as $col) {
                if (in_array($col, ['id', 'created_at', 'updated_at'])) {
                    continue;
                }
                $messages->orWhere($col, 'LIKE', "%$q%");
            }
            $messages = Message::whereIn('id', $messages->get()->pluck('id'));
        } else {
            $messages = Message::latest();
        }
        $messages = $messages->paginate(15);

        return view('admin.pages.messages.templates.message_template', compact('messages'))->render();
    }

    public function postAction($action, Request $r) {
        $state = 0;
        switch ($action) {
            case 'seen':
                $state = 1;
                break;
            case 'unseen':
                $action = 'seen';
                $state = 0;
                break;
            case 'deleted':
                $action = 'deleted';
                break;
            default :
                $data = ['status' => 'error', 'title' => 'خطا في العمليه', 'msg' => 'العمليه غير مدعومه'];
                return $data;
        }


        if ($r->has('ids')) {
            $ids = $r->input('ids');
            foreach ($ids as $id) {
                $this->_action($id, $action, $state);
            }
            $data = ['status' => 'success',
                'title' => 'نجاح',
                'msg' => 'تم بنجاح'];
        } else {
            $data = ['status' => 'warning',
                'title' => 'خطا',
                'msg' => 'برجاء اختيار عنصر واحد علي الاقل'];
        }

        return $data;
    }

    protected function _action($id, $action, $state) {
        $messages = Message::find($id);
        if ($action === 'deleted') {
            $messages->trash();
            return;
        }

        $messages->$action = $state;
        $messages->save();
    }

    public function getFilter($filter) {
        $messages = Message::latest();
        $messages = $this->_filter($messages, $filter)->paginate(15);
        return view('admin.pages.messages.templates.message_template', compact('messages'))->render();
    }

    protected function _filter(&$messages, $filter) {
        switch ($filter) {
            case 'all':
                return $messages;
            case 'seen':
                return $messages->where('seen', 1);
            case 'unseen':
                return $messages->where('seen', 0);
            case 'today':
                return $messages->where('created_at', '>=', Carbon::today()->toDateString());
        }
    }

}
