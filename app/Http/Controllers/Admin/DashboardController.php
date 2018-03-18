<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Project;
use App\Template;
use App\DataSource;
use App\User;


/**
 * Class DashboardController
 *
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    protected $breadcrumbs;
    protected $template;
    protected $data_source;
    protected $user;


    /**
     * DashboardController constructor.
     *
     * @param Project    $project
     * @param Template   $template
     * @param DataSource $data_source
     * @param User       $user
     */
    public function __construct(Project $project, Template $template, DataSource $data_source, User $user)
    {
        $this->project = $project;
        $this->template = $template;
        $this->data_source = $data_source;
        $this->user = $user;
    }


    /**
     * Renders the admin dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
	{
	    $pending_projects = $this->project->roots()->where('is_active', false)->get();
        $templates = $this->template->get();
        $data_sources = $this->data_source->orderBy('name', 'asc')->get();
        $users = $this->user->withCount('plans', 'projects')->orderBy('email', 'asc')->get();
        return view('admin.dashboard', compact('pending_projects', 'templates', 'data_sources', 'users'));
	}
}