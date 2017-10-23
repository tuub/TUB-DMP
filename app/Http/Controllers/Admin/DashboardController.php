<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Template;
use App\DataSource;
use App\User;


class DashboardController extends Controller
{
    protected $breadcrumbs;
    protected $template;
    protected $data_source;
    protected $user;

    public function __construct(Template $template, DataSource $data_source, User $user)
    {
        $this->template = $template;
        $this->data_source = $data_source;
        $this->user = $user;
    }

    public function index()
	{
        $templates = $this->template->get();
        $data_sources = $this->data_source->orderBy('name', 'asc')->get();
        $users = $this->user->withCount('plans', 'projects')->orderBy('email', 'asc')->get();
        return view('admin.dashboard', compact('templates', 'data_sources', 'users'));
	}

}