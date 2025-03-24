<?php

namespace App\Services\Dashboard;

use App\Mail\ContactSend;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mockery\Matcher\Contains;

class ContactUsService
{


    public function listing(Request $request)
    {
        $contacts = ContactUs::latest('id')->paginate($request->limit ?? 10);
        return $contacts;
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $contactUs = ContactUs::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            DB::commit();

            Mail::to($contactUs->email)->queue(new ContactSend($contactUs));
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    public function show($id)
    {
        $contactUs = ContactUs::findOrFail($id);
        return $contactUs;
    }

    // public function replay(Request $request, $id)
    // {
    // $contact = ContactUs::findOrFail($id);
    // }

    public function delete($id)
    {
        $contact = ContactUs::find($id);
        if($contact){
        $contact->delete();
        }else{

        }
    }
}
