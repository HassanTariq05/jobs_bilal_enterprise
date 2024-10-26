<?php

namespace App\Http\Controllers;

use App\Models\JournalVoucher;
use App\Models\JournalVoucherItem;
use App\Http\Requests\StoreJournalVoucherRequest;
use App\Http\Requests\UpdateJournalVoucherRequest;

use App\Models\Location;
use App\Models\AccountTitle;
use App\Models\VoucherType;

use Illuminate\Support\Facades\DB;

class JournalVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "journal-vouchers/";
    public function index()
    {
        $rows = JournalVoucher::all();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        $account_titles = AccountTitle::all();
        $voucher_types = VoucherType::all();
        return view($this->root . 'add', compact('locations', 'account_titles', 'voucher_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJournalVoucherRequest $request)
    {
        //echo "<pre>"; print_r($request->all());  exit();
        DB::beginTransaction();
        try {
            $y = date("Y");
            $prefix = get_specific_field_by_id('voucher_types', 'title', $request->voucher_type_id);
            $record = JournalVoucher::select('voucher_no')->where('voucher_type_id', $request->voucher_type_id)->orderBy('id', 'desc')->withTrashed()->first();
            if ($record) {
                $lastid = explode('-', $record->voucher_no);
                $lastid = (int)$lastid[1] + 1;
                $voucher_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $y;
            } else {
                $voucher_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $y;
            }
            $data = [
                'voucher_no' => $voucher_no,
                'voucher_type_id' => $request->voucher_type_id,
                'company_id' => $request->company_id,
                'account_title_id' => $request->account_title_id,
                'location_id' => $request->location_id,
                'date' => $request->date,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => $request->cheque_date,
                'pay_to' => $request->pay_to
            ];
            //echo "<pre>"; print_r($data);  exit();
            $voucher = JournalVoucher::create($data);
            for ($x = 0; $x < sizeof($request->item_location_id); $x++) {
                $data = [
                    'journal_voucher_id' => $voucher->id,
                    'account_title_id' => $request->item_account_title_id[$x],
                    'location_id' => $request->item_location_id[$x],
                    'debit' => $request->item_debit[$x],
                    'credit' => $request->item_credit[$x],
                ];
                $voucher = JournalVoucherItem::create($data);
            }
            DB::commit();
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return back()->with($alert);

        } catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JournalVoucher $journalVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JournalVoucher $journalVoucher, $id)
    {
        $row = JournalVoucher::find($id);
        if(!$row){
            return redirect()->route('journal-vouchers');
        }
        $locations = Location::all();
        $account_titles = AccountTitle::all();
        $voucher_types = VoucherType::all();
        return view($this->root . 'edit', compact('row', 'locations', 'account_titles', 'voucher_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJournalVoucherRequest $request, JournalVoucher $journalVoucher, $id)
    {
        DB::beginTransaction();
        try {
            $y = date("Y");
            $prefix = get_specific_field_by_id('voucher_types', 'title', $request->voucher_type_id);
            $record = JournalVoucher::select('voucher_no')->where('voucher_type_id', $request->voucher_type_id)->orderBy('id', 'desc')->withTrashed()->first();
            if ($record) {
                $lastid = explode('-', $record->voucher_no);
                $lastid = (int)$lastid[1] + 1;
                $voucher_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $y;
            } else {
                $voucher_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $y;
            }
            $data = [
                'voucher_no' => $voucher_no,
                'voucher_type_id' => $request->voucher_type_id,
                'company_id' => $request->company_id,
                'account_title_id' => $request->account_title_id,
                'location_id' => $request->location_id,
                'date' => $request->date,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => $request->cheque_date,
                'pay_to' => $request->pay_to
            ];
            JournalVoucher::where('id', $id)->update($data);
            JournalVoucherItem::where('journal_voucher_id', $id)->forceDelete();
            /*
            $record = JournalVoucher::find($id);
            $record->items()->each(function ($item, $key) {
                $item->forceDelete();
            });
            */
            for ($x = 0; $x < sizeof($request->item_location_id); $x++) {
                $data = [
                    'journal_voucher_id' => $id,
                    'account_title_id' => $request->item_account_title_id[$x],
                    'location_id' => $request->item_location_id[$x],
                    'debit' => $request->item_debit[$x],
                    'credit' => $request->item_credit[$x],
                ];
                JournalVoucherItem::create($data);
            }
            DB::commit();
            $alert = array(
                'message' => 'Updated successfully.',
                'alert-type' => 'success'
            );
            return back()->with($alert);

        } catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JournalVoucher $journalVoucher)
    {
        //
    }
}
