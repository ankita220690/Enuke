<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function index(Request $request)
    {
            $user= User::where('email', $request->email)->first();
            
            //check if user is valid user or not
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match.']
                ], 404);
            }
        
            //$token = $user->createToken('my-app-token')->plainTextToken;

            //image validation
            $valiodator = Validator::make($request->all(),[
                'file' => 'required|mimes:jpeg,jpg,png|max:500'
            ]);
            if($valiodator->fails()) {
                return response([
                    'message' => $valiodator->errors()
                ], 404);
            }
           
            //store image in folder
            $img_path = $request->file('file')->store('images');
        
            $response = [
                //'user' => $user,
                //'token' => $token,
                //'result_file' =>  $img_path,
                'Message' => 'File Uploaded Successfully'
            ];
            return response($data, 201);
    }

   
}
