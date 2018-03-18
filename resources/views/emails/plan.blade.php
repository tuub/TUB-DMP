@if($recipient['name'])
    Dear {!! $recipient['name'] !!},
@else
    Hello,
@endif

In the attachment please find the Data Management Plan "{!! $plan->title !!}" (Version {!! $plan->version !!}).

@if($msg)
    Additional Message:
    {!! $msg !!}
@endif

Best regards,
{!! $sender['name'] !!} ({!! $sender['email'] !!})


---
This e-mail has been automatically generated and sent via TUB-DMP.

TUB-DMP is the web tool for creating data management plans at TU Berlin.
https://dmp.tu-berlin.de

More information: http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/