<?php

namespace App\Exports;

use App\Models\ShopModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShopExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return Builder
     */
    public function query()
    {
        return ShopModel::query()->with('user.userProfile');
    }

/**
 * @return array
 */
    public function headings(): array
    {
        return [
            '#',
            'Owner',
            'Name',
            'Email',
            'Phone',
            'Address',
            'Created At',
            'Updated At',
        ];
    }

/**
 * @param mixed $shop
 * @return array
 */
    public function map($shop): array
    {
        static $row_number = 0;
        return [
            ++$row_number,
            $shop->user->userProfile->first_name . ' ' . $shop->user->userProfile->last_name,
            $shop->name,
            $shop->user->email,
            $shop->user->userProfile->phone ? $shop->user->userProfile->phone : '-',
            $shop?->address ? $shop->address . ', ' . $shop->village . ', ' . $shop->district . ', ' . $shop->regency . ', ' . $shop->province : $shop->village . ', ' . $shop->district . ', ' . $shop->regency . ', ' . $shop->province,
            $shop->created_at,
            $shop->updated_at,
        ];
    }
}
