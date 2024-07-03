<?php

namespace App\Exports;

use App\Models\userSubscription;
use App\Models\UserSubscriptionModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionOrderExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return Builder
     */
    public function query()
    {
        return UserSubscriptionModel::query()
                ->with('user');
    }

/**
 * @return array
 */
    public function headings(): array
    {
        return [
            '#',
            'Nama User',
            'Nama Langganan',
            'Harga',
            'Jangka Waktu',
            'Waktu Berakhir',
            'dibuat pada',
            'diperbarui pada'
        ];
    }

/**
 * @param mixed $userSubscription
 * @return array
 */
    public function map($userSubscription): array
    {
        static $row_number = 0;
        return [
            ++$row_number,
            $userSubscription->user->userProfile->first_name . ' ' . $userSubscription->user->userProfile->last_name,
            $userSubscription->subscription_name,
            $userSubscription->subscription_price,
            $userSubscription->subscription_time,
            Carbon::parse($userSubscription->expire)->format('d M Y'),
            $userSubscription->created_at,
            $userSubscription->updated_at,
        ];
    }
}