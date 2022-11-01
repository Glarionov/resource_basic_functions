<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentsRequest;
use App\Http\Services\AbstractAdvancedResourceService;
use App\Http\Services\AbstractResourceService;
use App\Http\Services\AppointmentService;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as RequestFacade;
use Inertia\Inertia;
abstract class AbstractResourceController extends Controller
{
    const RENDER_METHOD_INERTIA = 'inertia';

    protected static $mainService = AbstractAdvancedResourceService::class;

    protected static $requestType = null;

    protected static string $templatePrefix = '';

    protected static string $renderMethod = 'inertia';

    protected string $accept;

    public function __construct(Request $request)
    {
//        $this->accept = $request->header('Accept', null);
    }

    protected static function returnResult($data, $template = null, Request $request = null)
    {

//        todo r
        if (static::$renderMethod === static::RENDER_METHOD_INERTIA) {

            if ($request->header('Accept', null) === 'application/json') {
                return $data;
            }

            if (!$template) {

//                return Redirect::route('apples.index');
                if (isset($data['success']) && $data['success'] === false) {
                    return redirect()->back()->with([
                        'errorMessage' => $data['message'] ?? '',
                    ]);
                    return Redirect::back()->withErrors(['error' => 'error1']);
//                    return Redirect::back()->withErrors(['error' => $data['message'] ?? '']);


                    return Redirect::back()->with('error', 'error');
                    return Redirect::back()->with('success', false)->with('message', $data['message'] ?? '');
                }
                return Redirect::back()->with(['success' => true, 'errorMessage' => '']);
                return redirect(route('apples.index'));
//                return Redirect::back()->with('success', 'Organization updated.');
//                return $data;
            }

            return Inertia::render(static::$templatePrefix . $template, $data);
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return Inertia::render('Organizations/Index', [
//            'filters' => \Illuminate\Support\Facades\Request::all('search', 'trashed'),
//            'organizations' => Auth::user()->account->organizations()
//                ->orderBy('name')
//                ->filter(RequestFacade::only('search', 'trashed'))
//                ->paginate(10)
//                ->withQueryString()
//                ->through(fn ($organization) => [
//                    'id' => $organization->id,
//                    'name' => $organization->name,
//                    'phone' => $organization->phone,
//                    'city' => $organization->city,
//                    'deleted_at' => $organization->deleted_at,
//                ]),
//        ]);

        $data = static::$mainService::list($request->all());

        return static::returnResult($data, 'Index', $request);
    }

    public function create(Request $request)
    {
        return static::returnResult([], 'Create', $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @return Model
     */
    public function store(Request $request)
    {
        if (static::$requestType) {
            $request->validate(static::$requestType::generateInputRequestArray());
        }

        $data = static::$mainService::store($request->all());
        return static::returnResult($data,  null, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Model
     */
    public function show(Request $request, int $id)
    {
        $data = static::$mainService::show($id);
        return static::returnResult($data,  'Show', $request);
//        return static::$mainService::show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentsRequest  $request
     * @param  \App\Models\Appointment  $appointments
     * @return Model
     */
    public function update(Request $request, int $id)
    {
        if (static::$requestType) {
            $request->validate(static::$requestType::$updateRequestRules);
        }

        return static::$mainService::update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointments
     * @return Model
     */
    public function destroy(int $id)
    {
        return static::$mainService::update($id);
    }
}
