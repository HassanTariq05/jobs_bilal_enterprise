<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "banks/";
    public function index()
    {
        access_guard(25);
        $rows = Bank::withTrashed()->orderBy('title')->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(26);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        access_guard(26);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_name' => $request->short_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'email' => $request->email,
            'contact_person' => $request->contact_person,
        ];
        Bank::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        access_guard(25);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank, $id)
    {
        access_guard(27);
        $row = Bank::find($id);
        if (!$row) {
            return redirect()->route('banks');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, Bank $bank, $id)
    {
        access_guard(27);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_name' => $request->short_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'email' => $request->email,
            'contact_person' => $request->contact_person,
        ];
        Bank::where('id', $id)->update($data);
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
        access_guard(28);
        DB::beginTransaction();
         try {
            Bank::find($id)->delete();
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
        access_guard(29);
        DB::beginTransaction();
         try {
            Bank::withTrashed()->find($id)->restore();
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
        access_guard(30);
        $record = Bank::withTrashed()->find($id);
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
