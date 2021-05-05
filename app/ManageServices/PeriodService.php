<?php

namespace App\ManageServices;

use App\Http\Requests\Periods\ManageRequest;
use App\Models\Period;
use DomainException;
use Illuminate\Support\Facades\DB;

class PeriodService
{
    public function create(ManageRequest $request): Period {
        $status = Period::STATUS_INACTIVE;

        if (Period::all()->count() === 0) {
            $status = Period::STATUS_ACTIVE;
        }

        return Period::create([
            'started_at' => $request['started_at'],
            'ended_at' => $request['ended_at'],
            'status' => $status
        ]);
    }

    public function update(ManageRequest $request, Period $period): void
    {
        $period->update($request->only('started_at', 'ended_at'));
    }

    public function remove(Period $period): void {
        if ($period->status === Period::STATUS_ACTIVE) {
            throw new DomainException(__('messages.periods.active_cant_be_deleted'));
        }
        $period->delete();
    }

    public function activate(Period $period): void {
        DB::transaction(function () use ($period) {
            Period::whereStatus(Period::STATUS_ACTIVE)->update([
                'status' => Period::STATUS_INACTIVE
            ]);
            $period->update(['status' => Period::STATUS_ACTIVE]);
        });
    }
}
