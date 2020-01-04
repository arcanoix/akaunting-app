<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Common\Dashboard as Request;
use App\Models\Common\Dashboard as Model;
use App\Models\Common\Widget;
use App\Traits\DateTime;
use App\Utilities\Widgets as WidgetUtility;

class Dashboard extends Controller
{
    use DateTime;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dashboard_id = session('dashboard_id', 0);

        // Change Dashboard
        if (request()->get('dashboard_id', 0)) {
            $dashboard_id = request()->get('dashboard_id');

            session(['dashboard_id' => $dashboard_id]);
        }

        $dashboards = Model::where('user_id', user()->id)->enabled()->get();

        if (!$dashboard_id) {
            $dashboard_id = $dashboards->pluck('id')->first();
        }

        // Dashboard
        $dashboard = Model::find($dashboard_id);

        // Widgets
        $widgets = Widget::where('dashboard_id', $dashboard->id)->orderBy('sort', 'asc')->get()->filter(function ($widget) {
            return WidgetUtility::canRead($widget->class);
        });

        $financial_start = $this->getFinancialStart()->format('Y-m-d');

        return view('common.dashboard.index', compact('dashboards', 'dashboard', 'widgets', 'financial_start'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request['enabled'] = 1;
        $request['user_id'] = user()->id;

        $dashboard = Model::create($request->input());

        $response['data'] = $dashboard;
        $response['redirect'] = route('dashboard');

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Model  $dashboard
     *
     * @return Response
     */
    public function edit(Model $dashboard)
    {
        return response()->json($dashboard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Model  $dashboard
     * @param  $request
     * @return Response
     */
    public function update(Model $dashboard, Request $request)
    {
        $request['enabled'] = 1;
        $dashboard->update($request->input());

        $response['data'] = $dashboard;
        $response['redirect'] = route('dashboard');

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $dashboard
     *
     * @return Response
     */
    public function destroy(Model $dashboard)
    {
        $dashboard->delete();

        session(['dashboard_id' => user()->dashboards()->pluck('id')->first()]);

        $response['redirect'] = route('dashboard');

        return response()->json($response);
    }
}
