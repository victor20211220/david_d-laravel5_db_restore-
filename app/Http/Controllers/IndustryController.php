<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Industry;

use App\Http\Requests;

class IndustryController extends Controller
{
    //
    //
    public function index() {
        if (Auth::check()) {

            $industries = Industry::all()->sortBy('id', null, true);
            $category = DB::select('select category.id, industries.industry, category.industry_id, category.category from category INNER JOIN industries ON category.industry_id=industries.id');

            $data = array(
                'industry' => $industries,
                'category' => $category
            );

            return View::make('industries.index')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function create() {
        if (Auth::check()) {
            return View::make('industries.create');
        } else {
            return redirect("login");
        }
    }

    public function store() {
        if (Auth::check()) {
            // Create new database entry to store the industry into
            // Create validation rules

            $rules = array(
                'industry_name' => 'required'
            );

            // Validate
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('industries/create')->withErrors($validator)->withInput(Input::except('password'));
            } else {
                // Store in the database
                $industry = new Industry();
                $industry->industry = Input::get('industry_name');
                $industry->save();

                // redirect
                Session::flash('alert-success', 'Successfully created Industry');
                return Redirect::to('industries');
            }
        } else {
            return redirect("login");
        }
    }

    public function createCategory() {
        if (Auth::check()) {

            $industries = Industry::all();

            return View::make('industries.createCategory')->with('industry', $industries);
        } else {
            return redirect("login");
        }
    }

    public function storeCategory() {
        if (Auth::check()) {
            $rules = array(
                'category_name' => 'required',
                'category_industry' => 'required'
            );

            // Validate
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('industries/create')->withErrors($validator)->withInput(Input::except('password'));
            } else {
                // Store in the database
                $category = new Category();
                $category->industry_id = Input::get('category_industry');
                $category->category = Input::get('category_name');
                $category->save();

                // redirect
                Session::flash('alert-success', 'Successfully created Category');
                return Redirect::to('industries');
            }
        } else {
            return redirect("login");
        }
    }

    public function GetIndustriesJSON() {
        if (Auth::check()) {
            $category = DB::select('select category.id, industries.industry, category.industry_id, category.category from category INNER JOIN industries ON category.industry_id=industries.id');
			$industries = [];
            foreach ($category as $row) {
                $industry_name = $row->industry;
                $industries[$industry_name][] = $row->category;
            }
            return json_encode($industries);
        } else {
            return redirect("login");
        }
    }

    /* Edit - Delete */

    public function destroyIndustry($id) {
        if (Auth::check()) {
            $industry = Industry::find($id);
            $industry->delete();

            // redirect
            Session::flash('alert-success', 'Successfully deleted Industry');
            return Redirect::to('industries');
        } else {
            return redirect("login");
        }

    }

    public function destroyCategory($id) {
        if (Auth::check()) {
            $category = Category::find($id);
            $category->delete();

            // redirect
            Session::flash('alert-success', 'Successfully deleted Category');
            return Redirect::to('industries');
        } else {
            return redirect("login");
        }
    }

    public function edit($id) {
        if (Auth::check()) {
            $industry = Industry::find($id);

            return View::make('industries.edit')->with('industry', $industry);
        } else {
            return redirect("login");
        }
    }

    public function update($id) {
        if (Auth::check()) {
            $rules = array(
                'industry' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('industries/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                $industry = Industry::find($id);
                $industry->industry = Input::get("industry");
                $industry->save();

                Session::flash('alert-success', 'Successfully edited Industry');
                return Redirect::to('industries');
            }
        } else {
            return redirect("login");
        }
    }

    public function editCategory($id) {
        if (Auth::check()) {
            $category = Category::find($id);
            $industries = Industry::all();

            $data = array(
                'category' => $category,
                'industry' => $industries
            );

            return View::make('industries.categoryedit')->with($data);
        } else {
            return redirect("login");
        }
    }

    public function editCategoryStore($id) {
        if (Auth::check()) {
            $rules = array(
                'category_name' => 'required',
                'category_industry' => 'required'
            );

            // Validate
            $validator = Validator::make(Input::all(), $rules);

            if ($validator->fails()) {
                // If the validation fails then deal with it.
                Session::flash('alert-danger', 'An Error Occured.');
                return Redirect::to('industries/category/' . $id . '/edit')->withErrors($validator)->withInput(Input::except('password'));
            } else {
                // Store in the database
                $category = Category::find($id);
                $category->industry_id = Input::get('category_industry');
                $category->category = Input::get('category_name');
                $category->save();

                // redirect
                Session::flash('alert-success', 'Successfully updated Category');
                return Redirect::to('industries');
            }
        } else {
            return redirect("login");
        }
    }
}
