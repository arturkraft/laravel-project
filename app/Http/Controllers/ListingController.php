<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
   //get&show all listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

   //get&show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //show create form
    public function create() {
        return view('listings.create');
    }

    //Store Listing Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);



        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();


        Listing::create($formFields);




        return redirect('/')->with('successful-message', 'Listing created successfully!');
    }

    //Update Listing Data
    public function update(Request $request, Listing $listing){

        //Make sure logged in user is owner

        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorised Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);



        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $listing->update($formFields);




        return back()->with('successful-message', 'Listing updated successfully!');
    }



    //Show Edit Form 
    public function edit(listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    //Delete Listing

    public function destroy(Listing $listing){
                //Make sure logged in user is owner

                if($listing -> user_id != auth()->id()){
                    abort(403, 'Unauthorised Action');
                }
        $listing->delete();
        return redirect('/')->with('successful-message', 'Listing deleted successfully!');
    }

    //Manage Listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
