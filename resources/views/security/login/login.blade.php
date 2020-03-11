<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  @if (Config::get('system-security.cdnjs'))

  @else

  @endif

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
  @include('security.login.login-css')
  <title>{{ Config::get('system-security.system_title') }}</title>
</head>
<body>
  <div class="container-login">
    <div class="card custom-card shadow">
      <div class="card-body px-3 py-5">
        @if(Config::get('system-security.system_logo_login_is_visible') === true)
        <div class="row justify-content-center">
          <div class=col-6>
            @if(!empty(Config::get('system-security.system_logo_public_path')))
              <img src="{{ URL::asset(Config::get('system-security.system_logo_public_path')) }}" class="img-fluid mx-auto">
            @else
              <img src="{{ URL::asset('assets/kwaai/images/decimaerp.png') }}" class="img-fluid mx-auto">
            @endif
          </div>
        </div>
        @endif
        @if(!empty(Config::get('system-security.system_title') && Config::get('system-security.system_title_login_is_visible') === true))
        <div class="row justify-content-center">
          <div class=col-6>
            <h3 class="text-center">{{ Config::get('system-security.system_title') }}</h3>
          </div>
        </div>
        @endif
        <form id="decima-form" class="validate-form" role="form" method="POST" accept-charset="UTF-8" action="{{ URL::to('login/authentication-attempt') }}" onsubmit="return false;">
          <div id="user-container" class="mt-4 mb-4 {{ empty($lastLoggedUserEmail)?'d-none':''}}">
            <h5 class="card-title text-center">{{ Lang::get('security/login.welcome') }}</h5>
            <div class="d-flex justify-content-center">
              <button id="change-user" type="button" class="btn btn-outline-secondary py-1 rounded-pill" data-toggle="tooltip" data-placement="bottom" title="{{ Lang::get('security/login.change') }}">
                <i class="far fa-user-circle"></i>  {{ $lastLoggedUserEmail }}  <i class="fas fa-exchange-alt"></i>
              </button>
            </div>
          </div>
          <div id="email-container" class="mt-4 {{ !empty($lastLoggedUserEmail)?'d-none':''}}">
            <h5 class="card-title text-center">{{ Lang::get('form.access') }}</h5>
            <div class="form-group mb-1 mt-3 validate-input">
              <label for="decima-user" class="mb-1">{{ Lang::get('security/login.email') }}</label>
              <div>
                <input id="decima-user" type="email" class="form-control" value="{{ $lastLoggedUserEmail }}">
              </div>
            </div>
          </div>
          <div class="form-group mb-1 mt-3 validate-input">
            <label for="decima-password" class="mb-1">{{ Lang::get('security/login.password') }}</label>
            <div>
              <input id="decima-password" type="password" class="form-control">
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <div class="mb-4">
              <a href="{{ URL::to('password-reminder') }}" id="decima-forgotten-password">{{ Lang::get('security/login.forgottenPassword') }}</a>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button id="decima-next" type="button" class="btn btn-primary">
              <span class="decima-loader spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
              <span class="decima-loader" style="display:none;">{{ Lang::get('form.loadButton') }}</span>
              <span class="decima-next-label">{{ Lang::get('form.next') }}</span>
            </button>
          </div>
          {!! Honeypot::generate('kwaai-name', 'kwaai-time') !!}
        </form>
      </div>
    </div>
    <div>
      <small>{!! empty(Config::get('system-security.powered_by'))?Lang::get('security/login.poweredBy'):Config::get('system-security.powered_by') !!}</small>
    </div>
  </div>
  <button type="button" class="btn btn-outline-dark">Dark</button>
  @if (Config::get('system-security.cdnjs'))

  @else

  @endif
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.10.0/dist/sweetalert2.all.min.js"></script>
  <script src="https://storage.googleapis.com/decimaerp-cdn-bucket/kwaai/js/helpers-v1.1.1.js"></script>
  @include('layouts.header-javascript-global')
  @include('security.login.login-js')
</body>
</html>
