<?php

namespace App\Http\Controllers\Periods;

use App\Http\Controllers\Controller;
use App\Http\Requests\Periods\ManageRequest;
use App\Http\Resources\Periods\PeriodCollection;
use App\Models\Period;
use App\Services\PeriodService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PeriodsController extends Controller
{
    private $service;

    public function __construct(PeriodService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        $periods = Period::orderByDesc('started_at')->paginate(10);

        return Inertia::render('Periods/Index', [
            'periods' => new PeriodCollection($periods),
            'statuses' => Period::getStatuses()
        ]);
    }

    public function store(ManageRequest $request): RedirectResponse
    {
        $this->service->create($request);
        return redirect()->back()->with('success', __('messages.periods.create'));
    }

    public function destroy(Period $period): RedirectResponse
    {
        try {
            $this->service->remove($period);
        } catch (DomainException $exception) {
            return redirect()->back()->with('error', __($exception->getMessage()));
        }
        return redirect()->back()->with('success', __('messages.periods.delete'));
    }

    public function update(ManageRequest $request, Period $period): RedirectResponse
    {
        $this->service->update($request, $period);
        return redirect()->back()->with('success', __('messages.periods.update'));
    }

    public function activate(Period $period): RedirectResponse
    {
        $this->service->activate($period);
        return redirect()->back()->with('success', __('messages.periods.update'));
    }
}
