@extends('app')
@section('content')
<div class="container" ng-app="distributionApp">
     <div ng-controller="mainCtrl">
        <div ng-view>

        </div>
     </div>
</div>
@endsection

