<?php

namespace App\Http\Controllers\APIs;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'type' => 'required|max:255|string',
            'name' => 'required|max:255|string',
            'email' => 'required|max:255|string|email',
            'phone' => 'required|max:255|string',
            'subject' => 'required|max:255|string',
            'message' => 'required|string',
        ]);

        Contact::query()->create($request->all());

        return Response::success('Your message has been sent successfully');
    }
}
