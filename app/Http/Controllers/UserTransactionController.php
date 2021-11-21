<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transactionTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token' => 'required|exists:users,remember_token',
            'userid' => 'required|exists:users,id',
            'amount' => 'required',
            'touserid' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usersAmount = DB::table('user_balance')
            ->select('balance')
            ->where('userid', $request->userid)
            ->get();

        if ($usersAmount[0]->balance < $request->amount) {
            $data['status'] = 422;
            $data['message'] = 'your amount balance is not enough';

            return response()->json($data, 422);
        }


        DB::beginTransaction();


        DB::table('user_balance')
              ->where('userid', $request->touserid)
              ->increment('balance', $request->amount);


        DB::table('user_balance')
              ->where('userid', $request->userid)
              ->decrement('balance', $request->amount);
        DB::commit();


        $data['status'] = 200;
        $data['message'] = 'successful delivery';


        return response()->json($data, 200);
    }
}
