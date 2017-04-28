<meta charset="utf-8">
<title>@hasSection('title') @yield('title') | @endif{{ config('website.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
{{-- CSRF token for ajax vue-resource  --}}
<meta id="csrf-token" name="token" value="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ url('/assets/css/app.css') }}" media="screen">
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>