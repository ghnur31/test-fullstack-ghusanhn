<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        if ($addresses->count() > 0) {
            $data = [
                'status' => 200,
                'addresses' => $addresses
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Address Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'recipient_name' => 'required|string|max:255',
            'address_name' => 'required|string|max:255',
            'address_detail' => 'required|string',
            'phone' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $address = Address::create([
                'customer_id' => $request->customer_id,
                'recipient_name' => $request->recipient_name,
                'address_name' => $request->address_name,
                'address_detail' => $request->address_detail,
                'phone' => $request->phone,
                'postal_code' => $request->postal_code
            ]);

            if ($address) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Address Created Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong'
                ], 500);
            }
        }
    }


    public function show($id)
    {
        $address = Address::find($id);
        if ($address) {
            return response()->json([
                'status' => 200,
                'address' => $address
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Address not Found!'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'recipient_name' => 'required|string|max:255',
            'address_name' => 'required|string|max:255',
            'address_detail' => 'required|string',
            'phone' => 'required|string',
            'postal_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $address = Address::find($id);

            if ($address) {
                $address->update([
                    'recipient_name' => $request->recipient_name,
                    'address_name' => $request->address_name,
                    'address_detail' => $request->address_detail,
                    'phone' => $request->phone,
                    'postal_code' => $request->postal_code
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Address Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Address not Found!'
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        if ($address) {
            $address->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Address Deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Address not Found!'
            ], 404);
        }
    }
}
