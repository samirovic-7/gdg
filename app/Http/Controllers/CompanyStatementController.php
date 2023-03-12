<?php

namespace App\Http\Controllers;

use App\Models\Statement;
use Illuminate\Http\Request;
use App\Models\companyProfile;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class CompanyStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Statement::all());
    }
    public function companySatatePagination()
    {
        return response()->json(Statement::paginate(request()->segment(count(request()->segments()))));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'invoice_no'                 => 'required',
                'folio_no'                   => 'string',
                'guest_id'                   => 'integer|required',
                'company_id'                 => 'integer',
                'trans_date'                 => 'required|date_format:Y/m/d',
                'trans_no'                   => 'required|string',
                'trans_type'                 => 'required',
                'ref_no'                     => 'numeric|required',
                'description'                => 'required',
                'debit_amount'               => 'required',
                'credit_amount'              => 'required',
                'created_by'                 => 'integer',
                'void'                       => 'nullable',
                'void_datetime'              => 'nullable|after_or_equal:.date(Y-m-d H:i:s)',
                'paid_amount'                => 'required|string',
                'is_paid'                    => 'boolean',


            ]);


            $companyStatement = Statement::create([
                'invoice_no'         => $request->invoice_no,
                'folio_no'           => $request->folio_no,
                'company_id'         => $request->company_id,
                'trans_date'         => $request->trans_date,
                'trans_no'           => $request->trans_no,
                'trans_type'         => $request->trans_type,
                'ref_no'             => $request->ref_no,
                'description'        => $request->description,
                'debit_amount'       => $request->debit_amount,
                'credit_amount'      => $request->credit_amount,
                'created_by'         => $request->created_by,
                'void'               => $request->void,
                'void_datetime'      => $request->void_datetime,
                'paid_amount'        => $request->paid_amount,
                'is_paid'            => $request->is_paid,
                'guest_id'           => $request->guest_id,

            ]);

            return response()->json([
                'message'  => 'Company-Statement Created Successfully',
                'data' => $companyStatement], 201);
                 }catch(ValidationException $e){
                     return response()->json([
                    'message' => 'Validation Error',
                    'errors'  => $e->errors()],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        $companyStatement=Statement::find($id);
        return response()->json( $companyStatement);


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
         $validated = $request->validate([
            'invoice_no'                 =>'required|unique:statements,invoice_no|string|max:254',
            'folio_no'                   =>'required|unique:statements,folio_no',
            'company_id'                 =>'integer',
            'trans_date'                 =>'required|date_format:Y/m/d',
            'trans_no'                   =>'required|string',
            'trans_type'                 =>'required',
            'ref_no'                     =>'numeric|required',
            'description'                =>'required',
            'debit_amount'               =>'required',
            'credit_amount'              =>'required',
            'created_by'                 =>'integer',
            'void'                       =>'required',
            'void_datetime'              =>'required|date_format:Y/m/d',
            
            
        ]);

        $companyStatement = Statement::where('id',$id)->update([
            'invoice_no'         => $request-> invoice_no,
            'folio_no'           =>$request->folio_no,
            'company_id'         =>$request->company_id,
            'trans_date'         =>$request->trans_date,
            'trans_no'           =>$request->trans_no,
            'trans_type'         =>$request->trans_type,
            'ref_no'             =>$request->ref_no,
            'description'        =>$request->description,
            'debit_amount'       =>$request->debit_amount,
            'credit_amount'      =>$request->credit_amount,
            'created_by'         =>$request->created_by,
            'void'               =>$request->void,
            'void_datetime'      =>$request->void_datetime,
      
        ]);
        $companyStatement = Statement::where('id', $id)->get();

        return response([

            'message'  => 'Company-Statement Updated Successfully',
            'data' => $companyStatement], 200);
    }

    
public function AdvPayment(Request $request){
  try{
    //dd($request);
      $request->validate([
        'invoice_no'                 => 'required',
        'folio_no'                   => 'string',
        'company_id'                 => 'integer',
        'trans_date'                 => 'required|date_format:Y/m/d',
        'trans_no'                   => 'required|string',
        'trans_type'                 => 'required',
        'ref_no'                     => 'numeric|required',
        'description'                => 'required',
        'debit_amount'               => 'required',
        'credit_amount'              => 'required',
        'created_by'                 => 'integer',
        'void'                       => 'nullable',
        'void_datetime'              => 'nullable|after_or_equal:.date(Y-m-d H:i:s)',
        'paid_amount'                => 'required|string',
        'is_paid'                    => 'boolean',
    ]);

   // $Adv_Payment= Statement::where('invoice_no',$request->invoice_no)->first();
   // dd( $company_Statement);

   $Adv_Payment = Statement::create([

        'invoice_no'         => $request->invoice_no,
        'folio_no'           => $request->folio_no,
        'company_id'         => $request->company_id,
        'trans_date'         => $request->trans_date,
        'trans_no'           => $request->trans_no,
        'trans_type'         => $request->trans_type,
        'ref_no'             => $request->ref_no,
        'description'        => $request->description,
        'debit_amount'       => $request->debit_amount,
        'credit_amount'      => $request->credit_amount,
        'created_by'         => $request->created_by,
        'void'               => $request->void,
        'void_datetime'      => $request->void_datetime,
        'paid_amount'        => $request->paid_amount,
        'is_paid'            => $request->is_paid,

    ]);
   return response()->json([
                'message'  => 'Advanced Payment Created Successfully',
                'data'     => $Adv_Payment,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors'  => $e->errors(),
            ], 400);
        }
}

public function creditNote(Request $request){
    try{
        //dd($request);
          $request->validate([
            'invoice_no'                 => 'required',
            'folio_no'                   => 'string',
            'company_id'                 => 'integer',
            'trans_date'                 => 'required|date_format:Y/m/d',
            'trans_no'                   => 'required|string',
            'trans_type'                 => 'required',
            'ref_no'                     => 'numeric|required',
            'description'                => 'required',
            'debit_amount'               => 'required',
            'credit_amount'              => 'required',
            'created_by'                 => 'integer',
            'void'                       => 'nullable',
            'void_datetime'              => 'nullable|after_or_equal:.date(Y-m-d H:i:s)',
            'paid_amount'                => 'required|string',
            'is_paid'                    => 'boolean',
        ]);

       // $credit_Note=  Statement::where('invoice_no',$request->invoice_no)->first();
        $credit_Note = Statement::create([

            'invoice_no'         => $request->invoice_no,
            'folio_no'           => $request->folio_no,
            'company_id'         => $request->company_id,
            'trans_date'         => $request->trans_date,
            'trans_no'           => $request->trans_no,
            'trans_type'         => 'CRN',
            'ref_no'             => $request->ref_no,
            'description'        => $request->description,
            'debit_amount'       => $request->debit_amount,
            'credit_amount'      => $request->credit_amount,
            'created_by'         => $request->created_by,
            'void'               => $request->void,
            'void_datetime'      => $request->void_datetime,
            'paid_amount'        => $request->paid_amount,
            'is_paid'            => $request->is_paid,
    
        ]);

        $invoice_col = $request->invoices;
        foreach ($invoice_col as $invoice) {

            $company_Statement = Statement::where('invoice_no', $invoice['invoice_no'])->first();

            if (($company_Statement->debit_amount) == $invoice['Paid_amount']) {
                $company_Statement->update([
                    'is_paid'     => 1,
                    'paid_amount' => $invoice['Paid_amount'],
                ]);
            } elseif (($company_Statement->debit_amount) > $invoice['Paid_amount']) {
                if($company_Statement->paid_amount > 0){
                   
                    if(($company_Statement->paid_amount + $invoice['Paid_amount']) == $company_Statement->debit_amount ){
                        $company_Statement->update([
                            'is_paid'     => 1,
                            'paid_amount' => $company_Statement->paid_amount + $invoice['Paid_amount'],
                        ]); 
                    }else {
                       //dd(($company_Statement->paid_amount + $invoice['Paid_amount']));
                    $company_Statement->update([
                        'is_paid'     => 0,
                        'paid_amount' => ($company_Statement->paid_amount + $invoice['Paid_amount']),
                    ]); 
                }
                } else {
                    $company_Statement->update([
                        'is_paid'     => 0,
                        'paid_amount' => $invoice['Paid_amount'],
                    ]);  
                }
           
            } elseif (($company_Statement->debit_amount) < $invoice['Paid_amount']) {
                $company_Statement->update([
                    'is_paid'     => 2,
                    'paid_amount' => $invoice['Paid_amount'],
                ]);
            } else {
                $company_Statement->update([
                    'paid_amount' => $invoice['Paid_amount'],
                ]);
            }
        }

       // if($credit_Note->invoice_no)
       return response()->json([
                    'message'  => 'Credit-Note Created Successfully',
                    'data'     =>  $credit_Note,
                ], 201);
    
            } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors'  => $e->errors(),
                ], 400);
            }
}

public function debitNote(Request $request){
    try{
        //dd($request);
          $request->validate([
            'invoice_no'                 => 'required',
            'folio_no'                   => 'string',
            'company_id'                 => 'integer',
            'trans_date'                 => 'required|date_format:Y/m/d',
            'trans_no'                   => 'required|string',
            'trans_type'                 => 'required',
            'ref_no'                     => 'numeric|required',
            'description'                => 'required',
            'debit_amount'               => 'required',
            'credit_amount'              => 'required',
            'created_by'                 => 'integer',
            'void'                       => 'nullable',
            'void_datetime'              => 'nullable|after_or_equal:.date(Y-m-d H:i:s)',
            'paid_amount'                => 'required|string',
            'is_paid'                    => 'boolean',
        ]);
        $Debit_Note = Statement::create([

            'invoice_no'         => $request->invoice_no,
            'folio_no'           => $request->folio_no,
            'company_id'         => $request->company_id,
            'trans_date'         => $request->trans_date,
            'trans_no'           => $request->trans_no,
            'trans_type'         => 'DRN',
            'ref_no'             => $request->ref_no,
            'description'        => $request->description,
            'debit_amount'       => $request->debit_amount,
            'credit_amount'      => $request->credit_amount,
            'created_by'         => $request->created_by,
            'void'               => $request->void,
            'void_datetime'      => $request->void_datetime,
            'paid_amount'        => $request->paid_amount,
            'is_paid'            => $request->is_paid,
    
        ]);
       return response()->json([
                    'message'  => 'Debit-Note Created Successfully',
                    'data'     =>  $Debit_Note,
                ], 201);
    
            } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors'  => $e->errors(),
                ], 400);
            }
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $companyStatement=Statement ::where('id',$id)->delete();
        return response()->json([
            'status'     => true,
            'message'    => 'Company-Statement Deleted Successfully',
        ],201);
    }



    public function void($id)
    {
      $void = Statement::where('id', $id)->first();
       $now = Carbon::now();
       $void = Statement::create([
    
            'invoice_no'         => $void->invoice_no,
            'folio_no'           => $void->folio_no,
            'company_id'         => $void->company_id,
            'trans_date'         => $void->trans_date,
            'trans_no'           => $void->trans_no,
            'trans_type'         => $void->trans_type,
            'ref_no'             => $void->ref_no,
            'description'        => $void->description,
            'debit_amount'       => $void->debit_amount*-1,
            'credit_amount'      => $void->credit_amount*-1,
            'created_by'         => $void->created_by,
            'void'               => $void->void,
            'void_datetime'      => $void->void_datetime,
            'paid_amount'        => $void->paid_amount,
            'is_paid'            => $void->is_paid,
    
        ]);
        $void ->update([
            'void' => 1,
            'void_datetime' =>$now ,
        ]);

        return response()->json([
            'status'     => true,
            'message'    =>  'void Created Successfully',
        ], 201);
    }
}
