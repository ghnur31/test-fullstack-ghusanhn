<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('gender', 'like', '%' . $search . '%')
                    ->orWhereDate('birth_date', 'like', '%' . $search . '%');
            });
        }

        $customers = $query->with('addresses')->get();

        if ($customers->count() > 0) {
            $data = [
                'status' => 200,
                'customers' => $customers
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Customers Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048', // Max 2MB, jpeg or png
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('photos/customers', $photoName, 'public');
            $photoPath = url('storage/' . $photoPath); // Store the full URL
        }


        // Create customer record
        $customer = Customer::create([
            'name' => $request->name,
            'photo' => $photoPath,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        if ($customer) {
            return response()->json([
                'status' => 200,
                'message' => 'Customer Created Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to create customer.',
            ], 500);
        }
    }


    public function show($id)
    {
        $customer = Customer::with('addresses')->find($id);
        if ($customer) {
            // Tambahkan logika untuk memastikan URL foto lengkap
            if ($customer->photo) {
                $customer->photo = asset($customer->photo);
            }
            return response()->json([
                'status' => 200,
                'customer' => $customer
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not Found!'
            ], 404);
        }
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            // Tambahkan logika untuk memastikan URL foto lengkap
            if ($customer->photo) {
                $customer->photo = asset($customer->photo);
            }
            return response()->json([
                'status' => 200,
                'customer' => $customer
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not Found!'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048',
            'email' => 'email|unique:customers,email,' . $id,
            'phone' => 'string',
            'gender' => 'in:male,female',
            'birth_date' => '',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }

        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json([
                'status' => 404,
                'message' => 'Customer not found',
            ], 404);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($customer->photo) {
                Storage::delete('public/' . str_replace(url('storage/'), '', $customer->photo));
            }

            // Upload new photo
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photoPath = $photo->storeAs('photos/customers', $photoName, 'public');
            $photoPath = url('storage/' . $photoPath);
        } else {
            // Keep the existing photo path
            $photoPath = $customer->photo;
        }

        $customer->update([
            'name' => $request->name,
            'photo' => $photoPath,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Customer Updated Successfully',
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customers = Customer::find($id);
        if ($customers) {
            $customers->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not Found!'
            ], 404);
        }
    }
}