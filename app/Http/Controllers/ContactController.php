<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function createContact(ContactRequest $request){
        $contact = new Contact();
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->subject = $request->get('subject');
        $contact->message = $request->get('message');
        $contact = $contact->save();
        if($contact){
            return response()->json(['status' => true,'message' => 'Contact saved successfully']);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong ! Please try again later']);
        }
    }

    public function getAllContacts(){
        $contact = Contact::orderByDesc('created_at')->get();
        return response()->json(['status'=>true,'message'=>'Contact Information Fetched Successfully','data' => $contact]);
    }

    public function deleteContact($id){
        $contact = Contact::findOrFail($id);
        $contact = $contact->delete();
        if($contact){
            return response()->json(['status' => true,'message' => 'Contact deleted successfully']);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong ! Please try again later']);
        }
    }
}
