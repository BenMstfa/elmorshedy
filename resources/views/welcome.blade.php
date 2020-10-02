@extends('layouts.website')

@section('title')
    {{ trans('app.Home') }}
@endsection

@section('content')
    <div class="container-fluid remove-padding into-main block" id="home">
        <img src="img/1.jpg">
        <div class="container">
            <h1>{{ trans('app.Interior & Architecture Design') }}</h1>
            <p>{{ trans('app.We document inspiration. Our aim is to visualize, create and maintain beautiful homes for our clients. Our emphasis is on visuals that motivate you. We cover architectural & interior design innovations, finishing homes, furniture and decor. We hope to design your home one day!') }}</p>
            <a href="#" data-scroll="Contact" class="scroll-to">{{ trans('app.Contact Us') }}</a>
        </div>
    </div>

    <div class="container-fluid remove-padding about-main block" id="about">
        <h1>{{ trans('app.About Us') }} </h1>
        <div class="container">
            <h3>{{ trans('app.About Us') }}</h3>
            <p>{{ trans('app.We document inspiration. Our aim is to visualize, create and maintain beautiful homes for our clients. Our emphasis is on visuals that motivate you. We cover architectural & interior design innovations, finishing homes, furniture and decor. We hope to design your home one day!') }}</p>
            <a href="#" data-scroll="Contact" class="scroll-to">{{ trans('app.Get In Touch') }}</a>
        </div>

    </div>


    <div class="container-fluid ser-main block" id="Service">
        <div class="container remove-padding">
            <h1>{{ trans('app.Services') }}</h1>
            <p>{{ trans('app.we provide the best in class services for our customers') }}</p>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="col-xs-12 remove-padding">
                    <i class="ri-service-fill"></i>
                    <h3>{{ trans('app.Spend Money') }}</h3>
                    <p>{{ trans('app.Our aim is to visualize, create and maintain beautiful homes for our clients') }}</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="col-xs-12 remove-padding">
                    <i class="ri-patreon-fill"></i>
                    <h3>{{ trans('app.Set Budget') }}</h3>
                    <p>{{ trans('app.Our aim is to visualize, create and maintain beautiful homes for our clients') }}</p>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="col-xs-12 remove-padding">
                    <i class="ri-lock-unlock-fill"></i>
                    <h3>{{ trans('app.Security') }}</h3>
                    <p>{{ trans('app.Our aim is to visualize, create and maintain beautiful homes for our clients') }}</p>
                </div>
            </div>
        </div>

    </div>


    <div class="container remove-padding pro-main block" id="Project">

        <div class="col-xs-12 tab-head">
            <h1>{{ trans('app.Projects') }}</h1>
            <p>{{ trans('app.we provide the best in class services for our customers') }}</p>

            @for($i = 1; $i <= $projects->lastPage(); $i++)
                <a href="{{ route('index', ['page' => $i]) }}#Project" class="tab project-navigation-tab {{ $i == $projects->currentPage() ? 'active' : '' }}"
                   data-toggle-target=".tab-content-1">{{ trans('app.Tab') }} {{ $i }}</a>
            @endfor
        </div>

        <div class="tab-content tab-content-{{ $projects->currentPage() }} active">
            <div class="col-xs-12 remove-padding">
                @foreach($projects as $project)
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <a href="{{ route('project.details', ['id' => $project->id]) }}" class="flat-hover">
                            <img src="{{ $project->photos->first() }}">
                            <span>{{ $project->created_at }}</span>
                            <h3>{{ $project->name }}</h3>
                            <p>{{ $project->description }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
