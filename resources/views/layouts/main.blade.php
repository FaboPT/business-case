<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tasks App</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.includes.plugins')
    @include('layouts.includes.head_section')
</head>
{{--<body class="sidebar-mini"  style="height: auto;">--}}
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('layouts.includes.navbar_section')
    @include('layouts.includes.sidebar_section')
    @include('layouts.includes.content_section')
    @include('layouts.includes.footer_section')
</div>
</body>
<section class="footer">
    @include('layouts.includes.js_section')
</section>
</html>
