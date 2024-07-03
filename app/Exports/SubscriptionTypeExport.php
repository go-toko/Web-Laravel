<?php

namespace App\Exports;

use App\Models\SubscriptionTypeModel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SubscriptionTypeExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return Builder
     */
    public function query()
    {
        return SubscriptionTypeModel::query()
            ->orderBy('isActive', 'DESC')
            ->orderBy('time')
            ->orderBy('price');
    }

/**
 * @return array
 */
    public function headings(): array
    {
        return [
            '#',
            'Nama Langganan',
            'Deskripsi',
            'Harga',
            'Jangka Waktu',
            'Status',
        ];
    }

/**
 * @param mixed $subscriptionType
 * @return array
 */
    public function map($subscriptionType): array
    {
        static $row_number = 0;
        return [
            ++$row_number,
            $subscriptionType->name,
            $subscriptionType->description,
            $subscriptionType->price,
            $subscriptionType->time,
            $subscriptionType->isActive == 1 ? 'Aktif' : 'Tidak Aktif',
            $subscriptionType->created_at,
            $subscriptionType->updated_at,
        ];
    }
}
