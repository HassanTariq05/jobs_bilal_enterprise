<?php

namespace App\Http\Controllers;

use App\Models\AccountTitle;
use App\Http\Requests\StoreAccountTitleRequest;
use App\Http\Requests\UpdateAccountTitleRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class AccountTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "account-titles/";
    public function index()
    {
        access_guard(7);
        $rows = AccountTitle::withTrashed()->orderBy('account_nature_id')->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(8);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountTitleRequest $request)
    {
        access_guard(8);
        $data = [
            'short_name' => $request->short_name,
            'account_nature_id' => $request->account_nature_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        AccountTitle::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountTitle $accountTitle)
    {
        access_guard(7);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountTitle $accountTitle, $id)
    {
        access_guard(9);
        $row = AccountTitle::find($id);
        if(!$row){
            return redirect()->route('account-titles');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountTitleRequest $request, AccountTitle $accountTitle, $id)
    {
        access_guard(9);
        $data = [
            'short_name' => $request->short_name,
            'account_nature_id' => $request->account_nature_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        AccountTitle::where('id', $id)->update($data);
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
        access_guard(10);
        DB::beginTransaction();
         try {
            AccountTitle::find($id)->delete();
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
        access_guard(11);
        DB::beginTransaction();
         try {
            AccountTitle::withTrashed()->find($id)->restore();
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
        access_guard(12);
        $record = AccountTitle::withTrashed()->find($id);
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
