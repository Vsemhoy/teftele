
@extends('public.templates.main')


@section('page-menu')
    <h1>Привет Menu</h1> <i class='bi bi-chat-left-heart'></i>
    <i style='color: red; min-width: 50px; min-height: 50px;' class="bi bi-tools"></i>
@endsection


@section('page-content')
<div class="uk-container">

<div class="uk-grid-match uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">Card Title</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et mauris quis velit vestibulum pretium vel ac mauris. Ut vel nunc euismod, faucibus nulla a, sollicitudin justo.</p>
      </div>
    </div>
  </div>
  
</div>
  @endsection