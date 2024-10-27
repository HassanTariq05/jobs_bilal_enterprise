<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    private $root = "bank-accounts/";
    public function index()
    {
        access_guard(19);
        $rows = BankAccount::withTrashed()->orderBy('title')->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(20);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankAccountRequest $request)
    {
        access_guard(20);
        $data = [
            'bank' => $request->bank,
            'address' => $request->address,
            'title' => $request->title,
            'iban' => $request->iban,
            'company_id' => $request->company_id,
        ];
        BankAccount::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(BankAccount $bank_account)
    {
        access_guard(19);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankAccount $bank_account, $id)
    {
        access_guard(21);
        $row = BankAccount::find($id);
        if (!$row) {
            return redirect()->route('banks');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankAccountRequest $request, BankAccount $bank_account, $id)
    {
        access_guard(21);
        $data = [
            'bank' => $request->bank,
            'address' => $request->address,
            'title' => $request->title,
            'iban' => $request->iban,
            'company_id' => $request->company_id,
        ];
        BankAccount::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(22);
        DB::beginTransaction();
         try {
            BankAccount::find($id)->delete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function restore($id = 0)
    {
        access_guard(23);
        DB::beginTransaction();
         try {
            BankAccount::withTrashed()->find($id)->restore();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been restored successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function destroy($id = 0)
    {
        access_guard(24);
        $record = BankAccount::withTrashed()->find($id);
        if (!is_null($record)) {
            $record->forceDelete();
            $alert = array(
                'message' => 'Record deleted successfully',
                'alert-type' => 'success'
            );
        }else{
            $alert = array(
                'message' => 'Unable to delete record.',
                'alert-type' => 'error'
            );
        }
        return back()->with($alert);
    }

}
