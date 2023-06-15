@extends('layouts.app')
@section('title', 'TS')

@section('content')
    <form class="form-horizontal" role="form" action="{{ route('digital.ts') }}" method="post">
        @csrf
        <div class="form-group row">
            <label class="col-form-label text-md-right col-sm-2">Type: </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="type" value="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label text-md-right col-sm-2">SN: </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="sn" value="">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label text-md-right col-sm-2">ERROR: </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="error" value="">
            </div>
        </div>
        <div class="offset-sm-9 col-sm-9"><button type="submit" class="btn btn-primary btn-create-order">提交</button></div>
    </form>

@endsection
