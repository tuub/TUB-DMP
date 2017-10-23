<div class="panel panel-default">
    <div class="panel-heading text-center">
        All DataSources
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-fixed data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Identifier</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>URI</th>
                        <th data-orderable="false">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_sources as $data_source)
                        @include('admin.partials.data_source.info', $data_source)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
