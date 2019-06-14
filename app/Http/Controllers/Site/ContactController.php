<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use App\Message;

class ContactController extends Controller
{
    //
    public function getIndex()
    {
        $contact = Contact::get();

        return view('site.pages.contact.index' ,compact('contact'));
    }

    public function postIndex(Request $request){
        $message = new Message();

        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->message = $request->message;

        if($message->save()){
            $return = ['response' => 'success'];
        }else{
            $return = ['response' => 'error'];
        }

        return response()->json($return);
    }
}
