<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements FromQuery, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
     * @return Builder
     */
    public function query()
    {
        return User::query()->with('userProfile', 'userCashierProfile');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Nickname',
            'Email',
            'Phone',
            'Address',
            'Profile Gender',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * format column
     *
     * change format column in excel
     *
     * @param  $ 
     **/
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        static $row_number = 0;
        // $item->userProfile ? $item->userProfile->first_name . ' ' . $item->userProfile->last_name : $item->userCashierProfile->name
        return [
            ++$row_number,
            $user->userProfile ? $user->userProfile->first_name . ' ' . $user->userProfile->last_name : $user->userCashierProfile->name,
            $user->userProfile ? ($user->userProfile?->nickname ?? '-') : $user->userCashierProfile?->username,
            $user->email,
            $user->userProfile ? ($user->userProfile?->phone ?? '-') : ($user->userCashierProfile?->phone ?? '-'),
            $user->userProfile ? ($user->userProfile?->address ?? '-') : ($user->userCashierProfile?->address ?? '-'),
            $user->userProfile ? ($user->userProfile?->gender ?? '-') : ($user->userCashierProfile?->gender ?? '-'),
            $user->userProfile ? ($user->userProfile?->created_at ?? '-') : ($user->userCashierProfile?->created_at ?? '-'),
            $user->userProfile ? ($user->userProfile?->updated_at ?? '-') : ($user->userCashierProfile?->updated_at ?? '-'),
        ];
    }
}
