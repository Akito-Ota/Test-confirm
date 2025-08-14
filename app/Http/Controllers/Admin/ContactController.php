<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->get();
        $categories = Category::all();

        return view('contact');
    }
    public function store(ContactRequest $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        $contact = array_merge([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'detail'
        ]) + ['tel' => $tel];
        Contact::create($contact);
        return redirect('/thanks');
    }

    public function update(ContactRequest $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        $contact = array_merge([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'detail'
        ]) + ['tel' => $tel];
        Contact::find($request->id)->update($contact);
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Contact::find($request->contact_id)->delete();
        return redirect('/');
    }

    public function thanks()
    {
        return view('thanks');
    }
    public function confirm(Request $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        $contact = array_merge([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'address',
            'building',
            'detail'
        ]) + ['tel' => $tel];
        return redirect('confirm',compact('tel','contact'));
    }
}
