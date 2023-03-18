<?php
use App\Http\Controllers\Template\TemplateController;
use App\Http\Controllers\PublicPageController;
// Template switcher view
$template = new TemplateController();
$controller = new PublicPageController;
$topMenu = $controller->getAllTopMenuItems();

?>

@extends('public.templates.' . $template->templateFolderName . '.template')

@section('global-assets')
    <!-- initialize fontawesome -->
    <link rel="stylesheet" href="{{ asset('/public/vendor/bootstrap/icons/bootstrap-icons.css')}}"/>

@endsection

@section('system-scripts')
<script>
    @if(Auth::user())
      var user = {
        'id' : {{ Auth::user()->id }},
        'name' : '{{ Auth::user()->name }}',
      } ;
    @else
      var user = null;
    @endif

    var token = "<?php echo csrf_token(); ?>";

    async function authRelogger(){
        
        let data_ = {'user': '1', 'token' : token};

        let response = await fetch('/session/relogin/' + data_.user + '/' + data_.token + '/', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            "Content-Type": "application/json;charset=utf-8",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify(data_)
        });
        response.json().then(data => {
        if (data.message == "OK"){
          // placed in main template as script section
          token = data.token;
        } else {
            alert(data.message);
        }

        
      });    

    }
</script>
@endsection