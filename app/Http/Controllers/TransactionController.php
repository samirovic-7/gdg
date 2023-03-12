<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CalculationController;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function transaction_collection(Request $request)
    {
        Setting::find(1)->increment('transaction_collection');
    }
    public function calculate_excluded(Request $request)
    {
        $taxes = CalculationController::taxes($request->ledger_id, 0, $request->amount);
        return response()->json($taxes);
    }
    public function index()
    {

        $transactions = Transaction::with('created_by', 'updated_by', 'taxes')->get();
        return response()->json($transactions);
    }
    public function transactionPagination()
    {

        $transactions = Transaction::with('created_by', 'updated_by', 'taxes')->paginate(request()->segment(count(request()->segments())));
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'folio_id' => 'required|integer',
                'res_id' => 'required|integer',
                'room_id' => 'required|exists:rooms,id',
                'hotel_date' => 'required|date',
                'sys_date' => 'required|date',
                'ledger_id' => 'nullable|exists:ledgers,id|prohibited_unless:payment_type_id,null|required_without_all:payment_type_id,payment_amount',
                'payment_type_id' => 'nullable|integer|prohibited_unless:ledger_id,null|required_without_all:ledger_id,charge_amount',
                'charge_amount' => 'nullable|numeric|prohibited_unless:payment_amount,null|required_without_all:payment_type_id,payment_amount',
                'payment_amount' => 'nullable|numeric|prohibited_unless:charge_amount,null|required_without_all:ledger_id,charge_amount',
                'trans_type' => 'required|string',
                'recd_type' => 'required|string',
                'ref_id' => 'required|integer',
                'description' => 'required|string',
                'is_reservation' => 'required|boolean',
                'invoice_id' => 'required|integer',
                'inc' => 'required|boolean',
            ]);
            if ($request->ledger_id != null) {
                $taxes = CalculationController::taxes($request->ledger_id, $request->inc, $request->charge_amount);
                $inctaxes = $taxes->original->get('inctaxes');
                foreach ($inctaxes as $inc) {
                    // Push sync values to the array for each item
                    $syncValues[$inc['id']] = [
                        'name' => $inc['name'],
                        'name_loc' => $inc['name_loc'],
                        'amount' => $inc['value'],
                        'inc' => 1,
                    ];
                }
                $exctaxes = $taxes->original->get('exctaxes');
                foreach ($exctaxes as $inc) {
                    $syncValues[$inc['id']] = [
                        'name' => $inc['name'],
                        'name_loc' => $inc['name_loc'],
                        'amount' => $inc['value'],
                        'inc' => 0,
                    ];
                }
                $transaction_ledger = Transaction::where('ledger_id', $request->ledger_id)->max('trans_no');
                $transaction = Transaction::create([
                    'trans_no' => $transaction_ledger > 0 ? $transaction_ledger + 1 : 1,
                    'folio_id' => $request->folio_id,
                    'res_id' => $request->res_id,
                    'room_id' => $request->room_id,
                    'hotel_date' => $request->hotel_date,
                    'sys_date' => $request->sys_date,
                    'ledger_id' => $request->ledger_id,
                    'payment_type_id' => null,
                    'charge_amount' => $request->charge_amount,
                    'charge_without_taxes' => $taxes->original->get('total_with_tax'),
                    'payment_amount' => null,
                    'window_id' => $request->window_id,
                    'trans_type' => $request->trans_type,
                    'recd_type' => $request->recd_type,
                    'ref_id' => $request->ref_id,
                    'description' => $request->description,
                    'is_reservation' => $request->is_reservation,
                    'is_void' => 0,
                    'invoice_id' => $request->invoice_id,
                    'inc' => $request->inc,
                    'created_by' => auth()->user()->id,
                ]);
                $transaction->taxes()->sync($syncValues);
            } else {
                $transaction_payment_type = Transaction::where('payment_type_id', $request->payment_type_id)->max('trans_no');
                $transaction = Transaction::create([
                    'trans_no' => $transaction_payment_type > 0 ? $transaction_payment_type + 1 : 1,
                    'folio_id' => $request->folio_id,
                    'res_id' => $request->res_id,
                    'room_id' => $request->room_id,
                    'hotel_date' => $request->hotel_date,
                    'sys_date' => $request->sys_date,
                    'ledger_id' => null,
                    'payment_type_id' => $request->payment_type_id,
                    'charge_amount' => null,
                    'charge_without_taxes' => null,
                    'payment_amount' => $request->payment_amount,
                    'window_id' => $request->window_id,
                    'trans_type' => $request->trans_type,
                    'recd_type' => $request->recd_type,
                    'ref_id' => $request->ref_id,
                    'description' => $request->description,
                    'is_reservation' => $request->is_reservation,
                    'is_void' => 0,
                    'invoice_id' => $request->invoice_id,
                    'inc' => $request->inc,
                    'created_by' => auth()->user()->id,
                ]);
            }

            return response()->json(['transaction' => $transaction], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 400);
        }
    }

    public function show(Transaction $transaction)
    {
        return response()->json(['transaction' => $transaction]);
    }

    public function update(Request $request, Transaction $transaction)
    {

    }

    public function destroy(Transaction $transaction)
    {
        try {
            if ($transaction->ledger_id != null) {
                $taxes = CalculationController::taxes($transaction->ledger_id, $transaction->inc, $transaction->charge_amount);
                $inctaxes = $taxes->original->get('inctaxes');
                foreach ($inctaxes as $inc) {
                    // Push sync values to the array for each item
                    $syncValues[$inc['id']] = [
                        'name' => $inc['name'],
                        'name_loc' => $inc['name_loc'],
                        'amount' => $inc['value']*-1,
                        'inc' => 1,
                    ];
                }
                $exctaxes = $taxes->original->get('exctaxes');
                foreach ($exctaxes as $inc) {
                    $syncValues[$inc['id']] = [
                        'name' => $inc['name'],
                        'name_loc' => $inc['name_loc'],
                        'amount' => $inc['value']*-1,
                        'inc' => 0,
                    ];
                }
                $transaction_ledger = Transaction::where('ledger_id', $transaction->ledger_id)->max('trans_no');
                $transaction = Transaction::create([
                    'trans_no' => $transaction_ledger > 0 ? $transaction_ledger + 1 : 1,
                    'folio_id' => $transaction->folio_id,
                    'res_id' => $transaction->res_id,
                    'room_id' => $transaction->room_id,
                    'hotel_date' => $transaction->hotel_date,
                    'sys_date' => $transaction->sys_date,
                    'ledger_id' => $transaction->ledger_id,
                    'payment_type_id' => null,
                    'charge_amount' => $transaction->charge_amount * -1,
                    'charge_without_taxes' => $taxes->original->get('total_with_tax') * -1,
                    'payment_amount' => null,
                    'window_id' => $transaction->window_id,
                    'trans_type' => $transaction->trans_type,
                    'recd_type' => $transaction->recd_type,
                    'ref_id' => $transaction->ref_id,
                    'description' => $transaction->description,
                    'is_reservation' => $transaction->is_reservation,
                    'is_void' => 1,
                    'invoice_id' => $transaction->invoice_id,
                    'inc' => $transaction->inc,
                    'updated_by' => auth()->user()->id,
                ]);
                $transaction->taxes()->sync($syncValues);
            } else {
                $transaction_payment_type = Transaction::where('payment_type_id', $transaction->payment_type_id)->max('trans_no');
                $transaction = Transaction::create([
                    'trans_no' => $transaction_payment_type > 0 ? $transaction_payment_type + 1 : 1,
                    'folio_id' => $transaction->folio_id,
                    'res_id' => $transaction->res_id,
                    'room_id' => $transaction->room_id,
                    'hotel_date' => $transaction->hotel_date,
                    'sys_date' => $transaction->sys_date,
                    'ledger_id' => null,
                    'payment_type_id' => $transaction->payment_type_id,
                    'charge_amount' => null,
                    'charge_without_taxes' => null,
                    'payment_amount' => $transaction->payment_amount*-1,
                    'window_id' => $transaction->window_id,
                    'trans_type' => $transaction->trans_type,
                    'recd_type' => $transaction->recd_type,
                    'ref_id' => $transaction->ref_id,
                    'description' => $transaction->description,
                    'is_reservation' => $transaction->is_reservation,
                    'is_void' => 1,
                    'invoice_id' => $transaction->invoice_id,
                    'inc' => $transaction->inc,
                    'updated_by' => auth()->user()->id,
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 400);
        }
    }
}
