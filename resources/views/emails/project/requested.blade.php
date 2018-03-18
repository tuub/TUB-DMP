Hi,

A new project needs approval at {!! env('APP_URL') !!}/admin/

TUB project number: {!! $project['identifier'] !!}
Name: {!! $project->user->name !!}
Email: {!! $project->user->email !!}
Identifier: {!! $project->user->tub_om !!}
Institution Identifier: {!! $project->user->institution_identifier !!}
Institutional contact email address: {!! $project['contact_email'] !!}

Message: {!! $project['message'] !!}


---
This e-mail has been automatically generated and sent via TUB-DMP.

TUB-DMP is the web tool for creating data management plans at TU Berlin.
{!! env('APP_URL') !!}

More information:
http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/
http://www.szf.tu-berlin.de/menue/faq/nutzung_von_tub_dmp/