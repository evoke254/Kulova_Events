<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\Invite;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvitessImport implements ToCollection, WithHeadingRow, WithChunkReading
{

    public function __construct($event)
    {
        $this->event = $event;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {


            $phone_number = $row['phone'] ?? $row['phone_number'] ?? $row['mobile'];
            $phone_number = preg_replace('/\s+/', '', $phone_number);

            Invite::updateOrCreate(
                [
                    'event_id' => $this->event,
                    'member_no' => $row['member_no'] ?? $row['member no'] ?? $row['member number'] ?? null
                ],
                [
                    'event_id' => $this->event,
                    'name' => $row['name'],
                    'last_name' => $row['last name'] ?? $row['l_name'] ?? null,
                    'phone_number' => $phone_number,
                    'email' => $row['email'] ?? $row['mail'] ?? null,
                    'member_no' => $row['member_no'] ?? $row['member no'] ?? $row['member number'] ?? null,
                    'organization_id' => Auth::user()->organization_id,
                    'user_id' => Auth::id(),
                ]
            );
        }

    }

    public function chunkSize(): int
    {
        return 2500;
    }

}
