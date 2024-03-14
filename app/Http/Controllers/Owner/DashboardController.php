<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\ShopModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::user()->id;
        $shops = ShopModel::where([['user_id', $userId], ['isActive', true]])->orderBy('created_at', 'desc');
        if (Session::has('active')) {
            $id = Crypt::decrypt(Session::get('active'));
            return view('page.owner.index', [
                'shop' => $shops->where(['id' => $id])->first()
            ]);
        }
        return view('page.owner.index', [
            'shops' => $shops->get()
        ]);
    }

    public function setSession($id)
    {
        $name = ShopModel::where(['id' => Crypt::decrypt($id)])->first()->name;
        Session::put('active', $id);
        Session::put('name', $name);
        return redirect(route('owner.dashboard'));
    }

    public function deleteSession()
    {
        Session::forget('active');
        Session::forget('name');
        return redirect(route('owner.dashboard'));
    }
}
