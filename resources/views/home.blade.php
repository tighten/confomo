@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                        You must login before you can use Confomo.
                    </div>

                    <div id="confomo-app" class="container" v-cloak>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
