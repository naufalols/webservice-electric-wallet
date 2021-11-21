<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
            'amount' => 'required|digits_between:4,13',
            'touserid' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usersAmountBefore = DB::table('user_balance')
            ->select('user_balance.balance', 'users.remember_token')
            ->where('userid', $request->userid)
            ->join('users', 'users.id', '=', 'user_balance.userid')
            ->get();

        if ($usersAmountBefore[0]->remember_token != $request->user_token) {
            $data['status'] = 422;
            $data['message'] = 'Unprocessable Entity';
            return response()->json($data, 422);
        }


        if ($usersAmountBefore[0]->balance < $request->amount) {
            $data['status'] = 422;
            $data['message'] = 'your amount balance is not enough';
            return response()->json($data, 422);
        }

        DB::beginTransaction();

        // increment recipient amount
        $toUsersAmountBefore = DB::table('user_balance')
            ->select('balance')
            ->where('userid', $request->touserid)
            ->get();

        DB::table('user_balance')
            ->where('userid', $request->touserid)
            ->increment('balance', $request->amount);

        $toUsersAmountAfter = DB::table('user_balance')
            ->select('balance')
            ->where('userid', $request->touserid)
            ->get();

        DB::table('user_balance_history')->insert([
            'userBalanceId' => $request->touserid,
            'balanceBefore' => $toUsersAmountBefore[0]->balance,
            'balanceAfter' => $toUsersAmountAfter[0]->balance,
            'activity' => 'receive',
            'type' => 'kredit',
            'ip' => '',
            'location' => '',
            'userAgent' => '',
            'author' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // decrement sender amount
        DB::table('user_balance')
            ->where('userid', $request->userid)
            ->decrement('balance', $request->amount);

        $usersAmountAfter = DB::table('user_balance')
            ->select('balance')
            ->where('userid', $request->userid)
            ->get();

        DB::table('user_balance_history')->insert([
            'userBalanceId' => $request->userid,
            'balanceBefore' => $usersAmountBefore[0]->balance,
            'balanceAfter' => $usersAmountAfter[0]->balance,
            'activity' => 'send',
            'type' => 'debit',
            'ip' => '',
            'location' => '',
            'userAgent' => '',
            'author' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);


        DB::commit();


        $data['status'] = 200;
        $data['message'] = 'successful delivery';


        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function transactionTopUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_token' => 'required|exists:users,remember_token',
            'userid' => 'required|exists:users,id',
            'amount' => 'required|digits_between:4,13',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userCheck = DB::table('user_balance')
            ->select('user_balance.balance', 'users.remember_token')
            ->where('userid', $request->userid)
            ->join('users', 'users.id', '=', 'user_balance.userid')
            ->get();

        if ($userCheck[0]->remember_token != $request->user_token) {
            $data['status'] = 422;
            $data['message'] = 'Unprocessable Entity';
            return response()->json($data, 422);
        }

        DB::beginTransaction();

        DB::table('user_balance')
            ->where('userid', $request->userid)
            ->increment('balance', $request->amount);

        $userCheckAfter = DB::table('user_balance')
            ->select('balance')
            ->where('userid', $request->userid)
            ->get();

        DB::table('user_balance_history')->insert([
            'userBalanceId' => $request->userid,
            'balanceBefore' => $userCheck[0]->balance,
            'balanceAfter' => $userCheckAfter[0]->balance,
            'activity' => 'topup',
            'type' => 'kredit',
            'ip' => '',
            'location' => '',
            'userAgent' => '',
            'author' => '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        DB::commit();

        $data['status'] = 200;
        $data['message'] = 'successful topup';
        return response()->json($data, 200);
    }
}
