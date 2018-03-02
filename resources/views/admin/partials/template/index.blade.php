<div class="panel panel-default">
    <div class="panel-heading text-center">
        All Templates
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-fixed data-table col-md-24">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Sections</th>
                    <th>Usage Count</th>
                    <th>Active</th>
                    <th data-orderable="false">Tools</th>
                </tr>
                </thead>
                <tbody>
                    @foreach( $templates as $template )
                        @include('admin.partials.template.info', $template)
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {!! link_to_route('admin.template.create', 'Create') !!}
        </div>
    </div>
</div>
