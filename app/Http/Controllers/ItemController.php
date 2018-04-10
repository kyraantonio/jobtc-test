<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

use App\Models\Billing;
use App\Models\Item;


use Auth;
use Validator;
use View;
use Redirect;
use DB;
use Input;

class ItemController extends BaseController
{

    public function index()
    {
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function edit()
    {
    }

    public function store()
    {

        $billing = Billing::where('billing_id', '=', Input::get('billing_id'))
            ->where('billing_type', '=', Input::get('billing_type'))
            ->first();

        if (!$billing)
            return Redirect::to('billing/invoice')->withErrors("Wrong URL");

        $validation = Validator::make(Input::all(), [
            'item_name' => 'required|unique:item,item_name,null,item_id,billing_id,' . Input::get('billing_id'),
            'item_quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return Redirect::to('billing/' . $billing->billing_type . "/" . $billing->billing_id)->withInput()->withErrors($validation->messages());
        }


        $item = new Item;
        $data = Input::all();
        $item->fill($data);
        $item->save();

        return Redirect::to('billing/' . $billing->billing_type . '/' . Input::get('billing_id'))->withSuccess("Added successfully!!");
    }

    public function update()
    {
    }

    public function destroy($item_id)
    {
        $item = Item::find($item_id);
        if (!$item) {
            return Redirect::back()->withErrors('This is not a valid link!!');
        }
        $item->delete($item_id);
        return Redirect::back()->withSuccess('Deleted successfully!!');
    }
}

?>