<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tests\CreateRequest;
use App\Http\Requests\Tests\UpdateRequest;
use App\Models\Test;
use App\ManageServices\TestService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Inertia\Inertia;
use function __;
use function redirect;

class TestsController extends Controller
{
    /**
     * @var TestService
     */
    private $service;

    public function __construct(TestService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $tests = Test::all();

        return Inertia::render('Tests/Index', [
            'tests' => $tests
        ]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $this->service->create($request);
        return redirect()->route('tests.index')->with('success', __('messages.test.created'));
    }

    /**
     * @param Test $test
     * @return \Inertia\Response
     */
    public function show(Test $test)
    {
        return Inertia::render('Tests/Show', [
            'test' => $test
        ]);
    }

    /**
     * @param Test $test
     * @return Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * @param UpdateRequest $request
     * @param Test $test
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Test $test): RedirectResponse
    {
        $this->service->edit($test->id, $request);
        return redirect()->route('tests.index')->with('success', __('messages.test.updated'));
    }

    /**
     * @param Test $test
     * @return RedirectResponse
     */
    public function destroy(Test $test): RedirectResponse
    {
        $this->service->remove($test->id);
        return redirect()->route('tests.index')->with('success', __('messages.test.removed'));
    }
}
