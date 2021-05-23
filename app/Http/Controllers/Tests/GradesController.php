<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grades\CreateRequest;
use App\ManageServices\GradeService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GradesController extends Controller
{
    /**
     * @var GradeService
     */
    private GradeService $service;

    public function __construct(GradeService $service)
    {
        $this->service = $service;
    }

    public function update(CreateRequest $request): RedirectResponse
    {
        $this->service->updateGradesFromArray($request);

        return redirect()->back()->with('success', __('messages.grade.update'));
    }
}
