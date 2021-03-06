<div class="panel panel-default">
    <div class="panel-heading text-center">
        All Users
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-fixed data-table">
                <thead>
                <tr>
                    <th>TUB OM</th>
                    <th>Email</th>
                    <th class="text-center">Projects</th>
                    <th class="text-center">Admin</th>
                    <th class="text-center">Active</th>
                    <th>Last Login</th>
                    <th data-orderable="false">Tools</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $users as $user )
                    @include('admin.partials.user.info', $user)
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>