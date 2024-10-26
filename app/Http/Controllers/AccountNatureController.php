<?php

namespace App\Http\Controllers;

use App\Models\AccountNature;
use App\Http\Requests\StoreAccountNatureRequest;
use App\Http\Requests\UpdateAccountNatureRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class AccountNatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "account-natures/";
    public function index()
    {
        access_guard(1);
        $rows = AccountNature::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(2);

        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountNatureRequest $request)
    {

        access_guard(2);

        $data = [
            'code' => $request->code,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        AccountNature::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountNature $accountNature)
    {
        access_guard(1);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountNature $accountNature, $id)
    {

        access_guard(3);

        $row = AccountNature::find($id);
        if(!$row){
            return redirect()->route('account-natures');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountNatureRequest $request, AccountNature $accountNature, $id)
    {

        access_guard(3);

        $data = [
            'code' => $request->code,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        AccountNature::where('id', $id)->update($data);
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
         access_guard(4);
         DB::beginTransaction();
         try {
            AccountNature::find($id)->delete();
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
         access_guard(5);
         DB::beginTransaction();
         try {
            AccountNature::withTrashed()->find($id)->restore();
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
        access_guard(6);
        $record = AccountNature::withTrashed()->find($id);
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
