<?php

namespace App\Http\Controllers;

use App\Models\SalesTaxTerritory;
use App\Http\Requests\StoreSalesTaxTerritoryRequest;
use App\Http\Requests\UpdateSalesTaxTerritoryRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class SalesTaxTerritoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "sales-tax-territories/";
    public function index()
    {
        access_guard(185);
        $rows = SalesTaxTerritory::withTrashed()->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(186);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesTaxTerritoryRequest $request)
    {
        access_guard(186);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'head' => $request->head,
        ];
        SalesTaxTerritory::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesTaxTerritory $salesTaxTerritory)
    {
        access_guard(185);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesTaxTerritory $salesTaxTerritory, $id)
    {
        access_guard(187);
        $row = SalesTaxTerritory::find($id);
        if (!$row) {
            return redirect()->route('sales-tax-territories');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesTaxTerritoryRequest $request, SalesTaxTerritory $salesTaxTerritory, $id)
    {
        access_guard(187);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'head' => $request->head,
        ];
        SalesTaxTerritory::where('id', $id)->update($data);
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
        access_guard(188);
        DB::beginTransaction();
         try {
            SalesTaxTerritory::find($id)->delete();
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
        access_guard(189);
        DB::beginTransaction();
         try {
            SalesTaxTerritory::withTrashed()->find($id)->restore();
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
        access_guard(190);
        DB::beginTransaction();
         try {
            SalesTaxTerritory::withTrashed()->find($id)->forceDelete();
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
}
