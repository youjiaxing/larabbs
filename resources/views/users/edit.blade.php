@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include("shared._errors")

                        <div class="form-group">
                            <label for="name-field">用户名</label>
                            <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}"/>
                        </div>
                        <div class="form-group">
                            <label for="email-field">邮 箱</label>
                            <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}"/>
                        </div>
                        <div class="form-group">
                            <label for="introduction-field">个人简介</label>
                            <textarea name="introduction" id="introduction-field" class="form-control"
                                      rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label for="avatar-field" class="avatar-label">用户头像</label>
                            <input type="file" class="form-control-file" name="avatar" id="avatar-field" placeholder="" aria-describedby="fileHelpId">

                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" class="img-thumbnail img-responsive" alt="" width="200px">
                                @endif
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection