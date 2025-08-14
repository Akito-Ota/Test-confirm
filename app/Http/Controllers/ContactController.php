<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contacts', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'detail',
            'category_id'
        ]) + ['tel' => $tel];

        $request->merge(['tel' => $tel]);
        $request->flash();

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        $tel = $request->input('tel') ?? ($request->tel1 . $request->tel2 . $request->tel3);

        Contact::create($request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'detail',
            'category_id'
        ]) + ['tel' => $tel]);

        return redirect()->route('contacts.thanks');
    }

    public function thanks()
    {
        return view('thanks');
    }
}
