<?php

namespace App\Http\Controllers\Superadmin\Subscription;

use App\Exports\SubscriptionTypeExport;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionTypeModel;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SubscriptionTypeModel::where('status', '1')
            ->orderBy('isActive', 'DESC')
            ->orderBy('time')
            ->orderBy('price')
            ->get();
        return view('page.superadmin.subscription.management.index', [
            'subscriptions' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'description' => ['required'],
            'price' => ['required'],
            'time' => ['required', 'lte:12'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        $data = $request->all();

        try {
            DB::beginTransaction();

            SubscriptionTypeModel::create($data);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::error('Error when store data to databases in Subscription Type management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }

        Log::alert('Subscription Type has been created from user ' . Auth::user()->name . ' with Subscription Type name ' . $data['name']);
        return response()->json(['status' => 1, 'msg' => 'Success create the Subscription Type']);
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
        //Decrypt ID
        $id = Crypt::decrypt($id);

        //Get Data
        $data = SubscriptionTypeModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'description' => ['required'],
            'price' => ['required'],
            'time' => ['required', 'lte:12'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray(),
            ]);
        }

        $form = $request->all();

        try {
            DB::beginTransaction();

            $data->update($form);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::error('Error when update data to databases in Subscription Type management, the error is : \n' . $exception);
            return response()->json(['status' => 0, 'msg' => $exception]);
        }
        Log::alert('Subscription Type has been updated from user ' . Auth::user()->name . ' with Subscription Type name ' . $data['name']);
        return response()->json(['status' => 1, 'msg' => 'Success update the Subscription Type']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $id = Crypt::decrypt($id);
            $data = SubscriptionTypeModel::findOrFail($id);
            DB::beginTransaction();
            $data->update([
                'status' => 0,
            ]);
            DB::commit();
            Log::alert('Subscription type has been deleted from user ' . Auth::user()->name . ' with subscription type name' . $data->name);
            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            Log::error('Error when deleting data from subscription management, the error is : \n' . $th);
            return response()->json(['status' => 'error']);
        }
    }

    public function reportPdf()
    {
        // Mendapatkan data subscription type dari database
        $datas = SubscriptionTypeModel::where('status', '1')
            ->orderBy('isActive', 'DESC')
            ->orderBy('time')
            ->orderBy('price')
            ->get();

        // Menghasilkan HTML dari view laporan_list_user.blade.php dengan menggunakan data user
        $html = view('page.superadmin.subscription.management.report', compact('datas'));

        // Membuat instance Dompdf dan mengkonfigurasinya
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render file PDF
        $dompdf->render();

        // Memberikan respons HTTP dengan file PDF sebagai respon
        return $dompdf->stream(Carbon::now()->format('m-d-Y') . '_laporan_tipe_langganan.pdf');
    }

    public function reportExcel()
    {
        return Excel::download(new SubscriptionTypeExport, Carbon::now()->format('m-d-Y') . '_laporan_tipe_langganan.xlsx');
    }

}
