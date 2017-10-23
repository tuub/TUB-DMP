<?php

// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push('Admin Dashboard', route('admin.dashboard'));
});

// Admin > Templates
Breadcrumbs::register('templates', function ($breadcrumbs, $template) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Templates');
});

// Admin > Template > Sections
Breadcrumbs::register('sections', function ($breadcrumbs, $template) {
    $breadcrumbs->parent('templates', $template);
    $breadcrumbs->push('Sections: ' . $template->name);
});

// Admin > Template > Section > Questions
Breadcrumbs::register('questions', function ($breadcrumbs, $section) {
    $breadcrumbs->parent('templates', $section->template);
    $breadcrumbs->push('Sections: ' . $section->template->name, route('admin.template.sections.index', $section->template));
    $breadcrumbs->push('Questions: ' . $section->name);
});

// Admin > Users
Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Users');
});

// Admin > User > Projects
Breadcrumbs::register('projects', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Projects: ' . $user->email);
});

// Admin > User > Project > Plan
Breadcrumbs::register('plans', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Projects of ' . $project->user->email, route('admin.user.projects.index', $project->user));
    $breadcrumbs->push('Plans of Project ' . $project->identifier, route('admin.project.plans.index', $project));
});

// Admin > User > Project > Plan > Survey
Breadcrumbs::register('survey', function ($breadcrumbs, $plan) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Projects of ' . $plan->project->user->email, route('admin.user.projects.index', $plan->project->user));
    $breadcrumbs->push('Plans of Project ' . $plan->project->identifier, route('admin.project.plans.index',
        $plan->project));
    $breadcrumbs->push('Survey "' . $plan->title . '"');
});