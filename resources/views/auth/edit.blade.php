@extends('layouts.app')

@section('content')
<?php
  //page title
  $title = 'Edit <span>User</span>';
?>

<div class="container-fluid user">
    <div class="row">
      <div class="col-md-5 col-lg-3 contactdetails">
        <img class="add" src="{{ asset('/images/add-icon.svg') }}" alt="">

        <h3>Company</h3>
        <p class="company">{{ $company->companyName }}</p>
        <h3>Operator</h3>
        <p>{{ Auth::user()->name }}</p>

        <h3>Date</h3>
        <p><?php echo date('d.m.y') ?></p>

      </div>
      <div class="col-md-7 col-lg-9 form">
        @if (Auth::check())

        @canany ([\App\Enums\Permission::COMPANY_MANAGE->value, \App\Enums\Permission::COMPANY_MANAGE_ALL->value])

        <div class="row">

          <div class="col-md-8 form_wrapper">
            <form method="post" action="{{ url('/users/') }}/{{ $user->id }}" autocomplete="off">
                {{ csrf_field() }}

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="name" class="col-form-label">{{ __('Name') }}</label>

                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" id="name" value="{{ $user->name }}" />
                    @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>


                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="name" class="col-form-label">{{ __('Email') }}</label>

                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" id="email" value="{{ $user->email }}" />
                    @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="name" class="col-form-label">{{ __('Receive Notifications?') }}</label>

                    <select class="emailNotify" name="emailNotify" required>
                      <option value="0" @if ($user->emailNotify == 0 || $user->emailNotify == "") selected @endif >Yes</option>
                      <option value="1" @if ($user->emailNotify == 1) selected @endif >No</option>
                    </select>

                    @if ($errors->has('emailNotify'))
                    <span class="help-block">
                      <strong>{{ $errors->first('emailNotify') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="phone" class="col-form-label">{{ __('Phone') }}</label>


                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ $user->phone }}" />
                    @if ($errors->has('phone'))
                    <span class="help-block">
                      <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    @can(\App\Enums\Permission::USERS_READ_ALL->value)

                      <label for="name" class="col-form-label">{{ __('Access Level') }}</label>

                      <select class="form-control" name="accessLevel" id="accessLevel" required>
                        <option value="">Select an access level</option>
                        <option value="1" @if ($user->accessLevel == 1) selected @endif>Super Admin</option>
                        <option value="2" @if ($user->accessLevel == 2) selected @endif>Company Admin</option>
                        <option value="3" @if ($user->accessLevel == 3) selected @endif>Company User</option>
                      </select>

                          <select class="form-control" name="permissions[]" multiple id="permissions" required>
                              @foreach(\App\Enums\Permission::getRoleMap() as $role => $permissions)
                                  @foreach($permissions as $permission)
                                      <option value="{{$permission}}" data-role-id="{{$role}}" @if (!empty($user->permissions[$permission])) selected @endif>{{$permission}}</option>
                                  @endforeach
                              @endforeach
                          </select>

                    @endcan





                    @if ($errors->has('accessLevel'))
                    <span class="help-block">
                      <strong>{{ $errors->first('accessLevel') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>


                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    @can (\App\Enums\Permission::COMPANY_MANAGE_ALL->value)

                      <label for="companyId" class="col-form-label">{{ __('Company') }}</label>

                      <select class="form-control" name="companyId" id="companyId">
                        <option value="">Select a Company</option>
                        @foreach($companies as $companyId)
                          <option value="{{ $companyId->id }}" @if( $user->companyId  ==  $companyId->id ) selected @endif>{{ $companyId->companyName }}</option>
                        @endforeach
                      </select>

                    @endcan

                    @if ($errors->has('companyId'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companyId') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="password" class="col-form-label">{{ __('Password') }}</label>


                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" id="password" name="password" />

                    @if ($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <label for="password_confirmation" class="col-form-label">{{ __('Password Confirmation') }}</label>


                    <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" type="password" id="password_confirmation" name="password_confirmation" />

                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>

                <input class="d-none" type="text" id="disabled" name="disabled" value="{{ $user->disabled }}"  />

                <div class="form-group row">
                  <div class="offset-md-3 col-md-8">

                    <button class="btn btn-primary" type="submit">Send</button>

                  </div>
                </div>
            </form>
          </div>

          <div class="col-md-3 form_wrapper_details">

            @if (session('message'))
              <div class="flash-message">
                USER <br />
                SUCCESSFULLY<br />
                UPDATED.
                <a href="{{ url('/userlist/') }}"> < Back to User List</a>
              </div>
            @endif

          </div>

        </div>

          @else
          You have no business being here

          @endcanany

          @endif
      </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const permsSelect = document.querySelector('#permissions');
        const rolesSelect = document.querySelector('#accessLevel');
        rolesSelect.addEventListener('change', () => {
            permsSelect.value = '';
            const optionsToSelect = permsSelect.querySelectorAll(`[data-role-id="${rolesSelect.value}"]`);
            optionsToSelect.forEach((opt) => {
                opt.selected = true;
            })
        })
    })
</script>



@endsection
