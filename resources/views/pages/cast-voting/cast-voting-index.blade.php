@extends('layouts.app')

@section('content')

    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Cast Voting</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Cast Voting</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                        <h4 class="m-t-0 text-info">$58,356</h4></div>
                    <div class="spark-chart">
                        <div id="monthchart"></div>
                    </div>
                </div>
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                        <h4 class="m-t-0 text-primary">$48,356</h4></div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <!-- Validation wizard -->
    <div class="row">
        <div class="col-md-12 bg-white">
            <div class="row" id="validation">
                <div class="col-md-6 offset-md-3 col-sm-12">
                    <div class="wizard-content">
                        <div class="card-body bg-transparent">
                            <form action="{{route('cast-voting.store')}}" method="POST" class="validation-wizard wizard-circle">
                                @csrf
                                @foreach ($positions as $position => $candidates)
                                    <h5 class="text-danger">{{$candidates[0]->position->name}}</h5>
                                    <section>
                                        <div class="table-responsive">
                                            <table  class="table">
                                                <tbody>
                                                @php
                                                    $kojoCount = 0;
                                                @endphp
                                                <tr>
                                                    @foreach ($candidates as $candidate)
                                                        <td>
                                                            <div class="card">
                                                                <div class="card-body text-center">
                                                                    <img src="{{asset('nominee_img/'.$candidate->image)}}" class="img-circle" width="150" height="150" />
                                                                    <h4 class="card-title m-t-10">{{$candidate['last_name']." ".$candidate['other_name']." ".$candidate['first_name']}}</h4>
                                                                    <h6 class="card-subtitle text-danger font-16">{{$candidate->position->name}}</h6>
                                                                    <div class="form-group row text-center">
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <div class="m-b-10">
                                                                                <div id="checkbox_group">
                                                                                    @if(count($candidates) == 1)
                                                                                        <label class="inline custom-control custom-checkbox block">
                                                                                            <input type="checkbox" value="{{$candidate->id}}" required name="voteCasted[]" id="{{$candidate->position->id}}" class="custom-control-input cbox{{$candidate->position->id}}">
                                                                                            <span class="custom-control-label ml-0">Yes</span>
                                                                                        </label>

                                                                                        <label class="inline custom-control custom-checkbox block">
                                                                                            <input type="checkbox" value="" required name="voteCasted[]" id="{{$candidate->position->id}}" class="custom-control-input cbox{{$candidate->position->id}}">
                                                                                            <span class="custom-control-label ml-0">No</span>
                                                                                        </label>

                                                                                    @else
                                                                                        <label class="inline custom-control custom-checkbox block">
                                                                                            <input type="checkbox" value="{{$candidate->id}}" required name="voteCasted[]" id="{{$candidate->position->id}}" class="custom-control-input cbox{{$candidate->position->id}}">
                                                                                            <span class="custom-control-label ml-0">Vote</span>
                                                                                        </label>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @php
                                                            $kojoCount++;
                                                        @endphp
                                                        @if ($kojoCount >0)

                                                            @php
                                                                $kojoCount = 0;
                                                            @endphp
                                                </tr>
                                                @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    {{--<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body text-dark">
                    <h4 class="card-title"></h4>
                    <div class="table-responsive">
                        <table  class="table  " style="width: 100%">
                            <tbody>

                            @foreach ($positions as $position => $candidates)
                                @php
                                    $kojoCount = 0;
                                @endphp
                                <tr>
                                    @foreach ($candidates as $candidate)
                                        <td>
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <img src="{{asset('nominee_img/'.$candidate->image)}}" class="img-circle" width="150" height="150" />
                                                    <h4 class="card-title m-t-10">{{$candidate['last_name']." ".$candidate['other_name']." ".$candidate['first_name']}}</h4>
                                                    <h6 class="card-subtitle text-danger font-16">{{$candidate->position->name}}</h6>
                                                    <div class="row text-center justify-content-md-center">
                                                        <div class="col-12">
                                                            <form method="POST" action="{{route('cast-voting.store')}}">
                                                                @csrf
                                                                <input type="hidden" name="voting_id" value="{{$id}}">
                                                                <button name="position_number" type="submit" class="btn btn-success" value="{{$position_number}}">
                                                                    <i class="mdi mdi-thumb-up"></i>
                                                                    Vote
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @php
                                            $kojoCount++;
                                        @endphp
                                        @if ($kojoCount >1)

                                            @php
                                                $kojoCount = 0;
                                            @endphp
                                </tr>
                                <tr>
                                    @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

@endsection
