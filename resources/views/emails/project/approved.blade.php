Hi,

The project <{!! $project->identifier !!}> you requested has been approved and is now ready for you.
@if ($project->hasValidIdentifier() && $project->data_source)

External project metadata from "{!! $project->data_source->name !!}" has been imported.

@endif

Please go to {!! env('APP_URL') !!} to start working with it and to create DMPs.

Best regards,
{!! env('ADMIN_MAIL_NAME') !!}

---
This e-mail has been automatically generated and sent via TUB-DMP.

TUB-DMP is the web tool for creating data management plans at TU Berlin.
{!! env('APP_URL') !!}

More information:
http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/
http://www.szf.tu-berlin.de/menue/faq/nutzung_von_tub_dmp/