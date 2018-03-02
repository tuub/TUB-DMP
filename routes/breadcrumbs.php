<?php

// Admin
Breadcrumbs::register('admin', function ($breadcrumbs) {
    $breadcrumbs->push('Admin Dashboard', route('admin.dashboard'));
});

// Admin > Templates
Breadcrumbs::register('template_form', function ($breadcrumbs, $template, $mode) {
    $breadcrumbs->parent('admin');

    if ($template->name) {
        $breadcrumbs->push(trans('admin/template.title.' . $mode) . ' "' . $template->name . '"');
    } else {
        $breadcrumbs->push(trans('admin/template.title.' . $mode));
    }
});

// Admin > Template > Sections
Breadcrumbs::register('sections', function ($breadcrumbs, $template) {
    $breadcrumbs->parent('templates', $template);
    $breadcrumbs->push('Sections');
});

// Admin > Template > Sections > Create/Edit Section
Breadcrumbs::register('section_form', function ($breadcrumbs, $template, $section, $mode) {
    $breadcrumbs->parent('templates', $template);
    $breadcrumbs->push('Sections', route('admin.template.sections.index', $template));

    if ($section->name) {
        $breadcrumbs->push(trans('admin/section.title.' . $mode) . ' "' . $section->name . '"');
    } else {
        $breadcrumbs->push(trans('admin/section.title.' . $mode));
    }
});

// Admin > Template > Section > Questions
Breadcrumbs::register('questions', function ($breadcrumbs, $section) {
    $breadcrumbs->parent('templates', $section->template);
    $breadcrumbs->push('Section "' . $section->name . '"', route('admin.template.sections.index', $section->template));
    $breadcrumbs->push('Questions');
});

// Admin > Template > Section > Questions > Create/Edit Question
Breadcrumbs::register('question_form', function ($breadcrumbs, $template, $section, $question, $mode) {
    $breadcrumbs->parent('templates', $template);
    $breadcrumbs->push('Section "' . $section->name . '"', route('admin.template.sections.index', $template));
    $breadcrumbs->push('Questions', route('admin.section.questions.index', $section));
    if ($question->output_text) {
        $breadcrumbs->push(trans('admin/question.title.' . $mode) . ' "' . $question->output_text . '"');
    } else if ($question->text) {
        $breadcrumbs->push(trans('admin/question.title.' . $mode) . ' "' . $question->text . '"');
    } else {
        $breadcrumbs->push(trans('admin/question.title.' . $mode));
    }
});

// Admin > Users
Breadcrumbs::register('users', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('User "' . $user->email . '"', route('admin.dashboard'));
});

// Admin > User > Projects
Breadcrumbs::register('projects', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users', $user);
    $breadcrumbs->push('Projects');
});

// Admin > User > Projects > Create/Edit Project
Breadcrumbs::register('project_form', function ($breadcrumbs, $user, $project, $mode) {
    $breadcrumbs->parent('users', $user);
    $breadcrumbs->push('Projects', route('admin.user.projects.index', $user));
    if($project->identifier) {
        $breadcrumbs->push(trans('admin/project.title.' . $mode) . ' "' . $project->identifier . '"');
    } else {
        $breadcrumbs->push(trans('admin/project.title.' . $mode));
    }
});

// Admin > User > Project > Plan
Breadcrumbs::register('plans', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('users', $project->user);
    $breadcrumbs->push('Project "' . $project->identifier . '"', route('admin.user.projects.index', $project->user));
    $breadcrumbs->push('Plans', route('admin.project.plans.index', $project));
});

// Admin > User > Project > Plan > Survey
Breadcrumbs::register('survey', function ($breadcrumbs, $plan) {
    //$breadcrumbs->parent('users');
    //$breadcrumbs->push('Projects of ' . $plan->project->user->email, route('admin.user.projects.index', $plan->project->user));
    //$breadcrumbs->push('Plans of Project ' . $plan->project->identifier, route('admin.project.plans.index',
    //    $plan->project));
    //$breadcrumbs->push('Survey "' . $plan->title . '"');
});