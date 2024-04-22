<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class clientController extends Controller
{
    public function getClients() {

        $clients = Client::all();

        if ($clients->isEmpty()){
            return response()->json([
               'message' => 'No clients found'
            ], 200);
        }

        return response()->json($clients, 200); 
    }

    public function postClient(Request $request) {

            $isValidator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email",
                "phone" => "required",
                "password" => "required"
            ]);

            if($isValidator -> fails()) {
                $data = [
                    "message" => "error in validate info",
                    "errors" => $isValidator->errors(),
                    "status" => 404
                ];
                return response()->json($data, 404);
            };

            $client = Client::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "password" => $request->password
            ]);

            if (!$client) {
                $data = [
                    "message" => "error in create client",
                    "status" => 404
                ];
                return response()->json($data, 404);
            };

            $data = [
                "message" => "client created",
                "status" => 200
            ];
            return response()->json($data, 200);
    }

    public function getClient($id) {
         $client = Client::find($id);
         if (!$client) {
             $data = [
                 "message" => "client not found",
                 "status" => 404
             ];
             return response()->json($data, 404);
         }

         return response()->json($client, 200);
    }

    public function deleteClient($id) {
        $client = Client::find($id);
        if (!$client) {
            $data = [
                "message" => "client not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }
        $client->delete();
        $data = [
            "message" => "client deleted",
            "status" => 200
        ];
        return response()->json($data, 200);

    }

    public function putClient(Request $request, $id) {
        $client = Client::find($id);
        if (!$client) {
            $data = [
                "message" => "client not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }
         $idValidator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "password" => "required"
         ]);

          if($idValidator -> fails()) {
              $data = [
                  "message" => "error in validate info",
                  "errors" => $idValidator->errors(),
                  "status" => 404
              ];
              return response()->json($data, 404);
          };
          $client->name = $request->name;
          $client->email = $request->email;
          $client->phone = $request->phone;
          $client->password = $request->password;
          $client->save();

          if (!$client->save()) {
              $data = [
                  "message" => "error in update client",
                  "status" => 404
              ];
              return response()->json($data, 404);
          };
          
          $data = [
              "message" => "client updated",
              "status" => 200
          ];
          return response()->json($data, 200);

    }

    public function updatePartialClient(Request $request, $id) {

        $client = Client::find($id);
        if (!$client) {
            $data = [
                "message" => "client not found",
                "status" => 404
            ];
            return response()->json($data, 404);
        }
        $idValidator = Validator::make($request->all(), [
            "name" => "max:255",
            "email" => "email",
            "phone" => "digits:10",
            "password" => "max:255"
        ]);

        if($idValidator -> fails()) {
            $data = [
                "message" => "error in validate info",
                "errors" => $idValidator->errors(),
                "status" => 404
            ];
            return response()->json($data, 404);
        };

        if ($request->has("name")) {
            $client->name = $request->name;
        }
        if ($request->has("email")) {
            $client->email = $request->email;
        }
        if ($request->has("phone")) {
            $client->phone = $request->phone;
        }
        if ($request->has("password")) {
            $client->password = $request->password;
        }
        $client->save();

        if (!$client->save()) {
            $data = [
                "message" => "error in update client",
                "status" => 404
            ];
            return response()->json($data, 404);
        };

        $data = [
            "message" => "client updated",
            "status" => 200
        ];
        return response()->json($data, 200);
    }

}
