<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests\Admin\CreatePlanRequest;
use App\Http\Requests\Admin\UpdatePlanRequest;

use View;
use Session;

use App\Plan;
use App\Template;
use App\User;


class PlanController extends Controller
{
	protected $plan;
    protected $template;
    protected $user;

	public function __construct( Plan $plan, Template $template, User $user )
	{
		$this->plan = $plan;
        $this->template = $template;
        $this->user = $user;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = $this->plan->all();
        return View::make('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = new $this->plan;
        $templates = $this->template->all()->lists('name', 'id');
        $versions = ['1' => 1, '2' => 2, '3' => 3];
        $datasources = ['ivmc' => 'IVMC'];
        $users = $this->user->all()->lists('real_name', 'id');

        return View::make('admin.plan.new', compact('plan','templates','versions','users','datasources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePlanRequest $request)
    {
        $plan = new $this->plan;
        $plan->project_number = $request->get('project_number');
        $plan->version = $request->get('version');
        $plan->template_id = $request->get('template_id');
        $plan->datasource = $request->get('datasource');
        $plan->user_id      = $request->get('user_id');
        $plan->save();
        Session::flash('message', 'Successfully created the plan!');
        return Redirect::route('admin.plan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //session(['redirect' => Request::server('HTTP_REFERER')]);
        $plan = $this->plan->find($id);
        $templates = $this->template->all()->lists('name', 'id');
        $versions = ['1' => 1, '2' => 2, '3' => 3];
        $datasources = ['ivmc' => 'IVMC'];
        $users = $this->user->all()->lists('real_name', 'id');
        return View::make('admin.plan.edit', compact('plan','templates','versions','datasources','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlanRequest $request, $id)
    {
        $plan = $this->plan->find($id);
        $data = $request->except('_token');
        array_walk($data, function (&$item) {
            $item = ($item == '') ? null : $item;
        });
        $plan->update( $data );
        return Redirect::route('admin.plan.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = $this->plan->find($id);
        dd($plan->answers);
        //$plan->delete();
        Session::flash('message', 'Successfully deleted plan!');
        return Redirect::route('admin.plan.index');
    }



    public function prefill()
	{
		$plans = $this->plans->all();
		dd($plans);
        //Artisan::call('dmp:prefill');
        //Notifier::success( Artisan::output() )->flash()->create();
        //return 'yooo';
        //Redirect::to( 'admin.dashboard' );
	}

}