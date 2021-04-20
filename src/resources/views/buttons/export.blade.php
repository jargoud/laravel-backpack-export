@php($id = 'export-button-' . Illuminate\Support\Str::random())

<a href="{{ url($crud->route . '/export') }}" id="{{ $id }}" class="btn btn-primary">
  <span class="la la-download"></span> Exporter
</a>

@push('after_scripts')
  <script>
    document
      .getElementById("{{ $id }}")
      .addEventListener("click", function (event) {
        event.preventDefault();

        window.location = event.target.href + window.location.search;
      });
  </script>
@endpush
