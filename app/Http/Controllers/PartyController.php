<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\PartyType;
use App\Http\Requests\StorePartyRequest;
use App\Http\Requests\UpdatePartyRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "parties/";
    public function index()
    {
        access_guard(197);
        $rows = PartyType::withTrashed()->get();
        if($rows){
            foreach($rows as $i=>$k){
                $k->parties = Party::where('party_type_id', $k->id)->orderBy('title')->get();
                $rows[$i] = $k;
            }
        }
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(198);
        $party_types = PartyType::all();
        return view($this->root . 'add', compact('party_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartyRequest $request)
    {
        access_guard(198);
        $data = [
            'party_type_id' => implode(',', $request->party_type_id),
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'contact' => $request->contact,
            'email' => $request->email,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'ntn' => $request->ntn,
            'contact_person' => $request->contact_person,
        ];
        Party::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Party $party)
    {
        access_guard(197);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Party $party, $id)
    {
        access_guard(199);
        $party_types = PartyType::all();
        $row = Party::find($id);
        if (!$row) {
            return redirect()->route('parties');
        }
        return view($this->root . 'edit', compact('row', 'party_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartyRequest $request, Party $party, $id)
    {
        access_guard(199);
        $data = [
            'party_type_id' => implode(',', $request->party_type_id),
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
            'contact' => $request->contact,
            'email' => $request->email,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'ntn' => $request->ntn,
            'contact_person' => $request->contact_person,
        ];
        Party::where('id', $id)->update($data);
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
        access_guard(200);
        DB::beginTransaction();
         try {
            Party::find($id)->delete();
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
        access_guard(201);
        DB::beginTransaction();
         try {
            Party::withTrashed()->find($id)->restore();
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
        access_guard(202);
        DB::beginTransaction();
         try {
            Party::withTrashed()->find($id)->forceDelete();
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
