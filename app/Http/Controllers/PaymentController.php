<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;

class PaymentController extends BaseController
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

        $validation = Validator::make(Input::all(), [
            'payment_amount' => 'required|numeric',
            'payment_date' => 'date',
            'payment_notes' => 'required',
            'payment_type' => 'required|in:cash,bank',
            'billing_id' => 'required'
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withInput()->withErrors($validation->messages());
        }

        $billing = Billing::where('billing_id', '=', Input::get('billing_id'))
            ->where('billing_type', '=', 'invoice')
            ->first();

        if (!$billing)
            return Redirect::back()->withErrors('This is not a valid link!!');

        $payment = new Payment;
        $data = Input::all();
        $data['username'] = Auth::user()->username;
        $payment->fill($data);
        $payment->save();

        return Redirect::back()->withSuccess('Successfully saved!!');
    }

    public function update()
    {
    }

    public function destroy($payment_id)
    {
        $payment = Payment::find($payment_id);

        if (!$payment || !Entrust::hasRole('Admin'))
            return Redirect::back()->withErrors('This is not a valid link!!');

        $payment->delete($payment_id);
        return Redirect::back()->withSuccess('Deleted Successfully!!');
    }
}

?>