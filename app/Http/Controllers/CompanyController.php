<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "companies/";
    public function index()
    {
        access_guard(191);
        $rows = Company::withTrashed()->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(192);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        access_guard(192);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'contact_person' => $request->contact_person,
            'ntn' => $request->ntn,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = request()->file('logo')->store('company', 'public');
        }

        Company::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        access_guard(191);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company, $id)
    {
        access_guard(193);
        $row = Company::find($id);
        if (!$row) {
            return redirect()->route('companies');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company, $id)
    {
        access_guard(193);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'contact_person' => $request->contact_person,
            'ntn' => $request->ntn,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = request()->file('logo')->store('company', 'public');
        }

        Company::where('id', $id)->update($data);
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
        access_guard(194);
        DB::beginTransaction();
         try {
            Company::find($id)->delete();
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
        access_guard(195);
        DB::beginTransaction();
         try {
            Company::withTrashed()->find($id)->restore();
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
        access_guard(196);
        $record = Company::withTrashed()->find($id);
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
