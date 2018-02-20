<div class="panel panel-default">
    <div class="panel-heading text-center">
        Pending Projects
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-fixed data-table">
                <thead>
                <tr>
                    <th>Identifier</th>
                    <th>User</th>
                    <th>Institutional Contact</th>
                    <th>Requested</th>
                    <th data-orderable="false">Tools</th>
                </tr>
                </thead>
                <tbody>
                    @foreach( $pending_projects as $project )
                        @include('admin.partials.project.pending_info', $project)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
