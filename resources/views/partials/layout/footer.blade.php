@section('footer')
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                &copy; {{ date("Y") }}
                {{ HTML::link('http://www.szf.tu-berlin.de/', trans('general.footer.link-01'), ['target' => '_blank']) }}
            </div>
            <div class="text-center">
                {{ HTML::link('http://www.szf.tu-berlin.de/menue/dienste_tools/datenmanagementplan_tub_dmp/', trans('general.footer.link-02'), ['target' => '_blank']) }}
                |
                {{ HTML::link('http://www.szf.tu-berlin.de/menue/ansprechpartnerinnen/', trans('general.footer.link-03'), ['target' => '_blank']) }}
                |
                {{ HTML::link('http://www.szf.tu-berlin.de/servicemenue/impressum/', trans('general.footer.link-04'), ['target' => '_blank']) }}
                |
                {{ HTML::link('http://www.tu-berlin.de/allgemeine_seiten/datenschutz/', trans('general.footer.link-05'), ['target' => '_blank']) }}
            </div>
        </div>
    </footer>

    @if( Auth::check() )
        @include('partials.modal')
    @endif


    @section('footer_assets')
        {!! HTML::script('js/vendor.js') !!}
        {!! HTML::script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') !!}
        {!! HTML::script('js/my.jquery.js') !!}
    @show

    </body>
    </html>
@show