<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\RolesModel;
use App\Models\ShopModel;
use App\Models\User;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $role = RolesModel::with([
            'roleMenu' => function ($query) {
                $query->orderBy('order', 'ASC');
            },
            'roleMenu.menu.subMenu',
        ])->get();
        $users = User::orderBy('last_seen', 'DESC')->paginate(4);
        return view('page.superadmin.index', [
            'roles' => $role,
            'users' => $users,
        ]);
    }

    public function getUserCount()
    {
        $userCount = User::all()->count();
        return response()->json(['userCount' => $userCount]);
    }

    public function getUserOnlineCount()
    {
        $current_time = Carbon::now();
        $five_minutes_ago = $current_time->subMinutes(5);

        $userOnlineCount = User::where('last_seen', '>', $five_minutes_ago)
            ->count();
        return response()->json(['userOnlineCount' => $userOnlineCount]);
    }

    public function getSubscriberCount()
    {
        $current_time = Carbon::now();
        $subscriber = UserSubscriptionModel::where('expire', '>', $current_time)->count();

        return response()->json(['subscriberCount' => $subscriber]);
    }

    public function getSubscriberChart()
    {
        $monthlySubscriptions = UserSubscriptionModel::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as total')
            ->groupBy('month')
            ->get();

        $labels = $monthlySubscriptions->pluck('month');
        $data = $monthlySubscriptions->pluck('total');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function getShopsCount()
    {
        $shopsCount = ShopModel::all()->count();
        return response()->json(['shopsCount' => $shopsCount]);
    }
}