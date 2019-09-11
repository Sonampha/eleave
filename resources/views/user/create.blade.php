@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Create New User</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="full_name" id="full_name" value="{{Request::old('full_name') ? : ''}}">
                                <label for="full_name">Full Name</label>
                                <span class="{{$errors->has('full_name') ? 'helper-text red-text' : ''}}">{{$errors->first('full_name')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : ''}}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="password" id="password" value="{{Request::old('password') ? : ''}}">
                                <label for="password">Password</label>
                                <span class="{{$errors->has('password') ? 'helper-text red-text' : ''}}">{{$errors->has('password') ? $errors->first('password') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" value="{{Request::old('email') ? : ''}}">
                                <label for="email">Email</label>
                                <span class="{{$errors->has('email') ? 'helper-text red-text' : ''}}">{{$errors->has('email') ? $errors->first('email') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <i class="material-icons prefix">vpn_key</i>
                                <select name="user_type" class="validate" required>
                                    <option value="" disabled {{ old('user_type')? '' : 'selected' }}>User Types</option>
                                    @foreach($user_types as $user_type)
                                    <option value="{{ $user_type->user_type }}" {{ old('user_type') == $user_type->user_type ? 'selected' : '' }}>
                                        {{ $user_type->user_type }}
                                    </option>
                                    @endforeach
                                </select>
                                <label>User Type</label>
                            </div>
                            <div class="file-field input-field col s12 m8 offset-m2 l8 offset-l2 xl8 offset-xl2">
                                <div class="btn">
                                    <span>Picture</span>
                                    <input type="file" name="picture">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="{{old('picture') ? : '' }}">
                                    <span class="{{$errors->has('picture') ? 'helper-text red-text' : ''}}">{{$errors->has('picture') ? $errors->first('picture') : ''}}</span>
                                </div>
                            </div>
                        </div>
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Add</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/users">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection