<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view ('index',compact('categories'));
    }

    public function confirm(ContactRequest $request){
        $contact = $request->only(['first_name','last_name','gender','email','tel_1','tel_2','tel_3','address','building','category_id','detail']);
    
        // tel を連結
        $contact['tel'] = $contact['tel_1'] . '-' . $contact['tel_2'] . '-' . $contact['tel_3'];
    
        $categories = Category::all();

        $request->session()->put('contact', $contact);
    
        return view('confirm', ['contact' => $contact,'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $contact = $request->session()->get('contact');

        Contact::create([
            'last_name' => $contact['last_name'],
            'first_name' => $contact['first_name'],
            'gender' => $contact['gender'],
            'email' => $contact['email'],
            'tel' => $contact['tel'],
            'address' => $contact['address'],
            'building' => $contact['building'],
            'category_id' => $contact['category_id'],
           'detail' => $contact['detail'],
        ]);
    
        return redirect()->route('thanks');
    }

    public function thanks(){
        return view('thanks');
    }


    public function create()
{
    $categories = Category::all(); 

    return view('index', compact('categories'));
}


}
