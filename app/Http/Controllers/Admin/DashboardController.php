<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Template;
use App\Plan;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller {

	protected $template;
	protected $plan;

	public function __construct( Template $template, Plan $plan )
	{
        $this->beforeFilter('auth');
		$this->template = $template;
		$this->plan = $plan;
	}
    
    public function index()
	{
		$templates = $this->template->active()->get();
		$plans = $this->plan->all();
        //$internal_templates = Template::where('institution_id', '=', 1)->lists('name','id');
        //$external_templates = Template::where('institution_id', '!=', 1)->lists('name','id');
        //$template_selector = array('TU Berlin' => $internal_templates) + array('Andere Organisationen' => $external_templates);
        return View::make('admin.dashboard', compact('templates', 'plans'));
	}

}