@extends('layouts.core.frontend_no_subscription', [
    'menu' => 'keywords',
])
//resources/views/account/keywords_listing.blade.php
@section('title', trans('messages.keywords_listing'))

@section('head')
    <script type="text/javascript" src="{{ AppUrl::asset('core/js/group-manager.js') }}"></script>
@endsection

@section('page_header')
    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item active">{{ trans('messages.keywords') }}</li>
        </ul>
        <h1>
            <span class="text-semibold"><i class="icon-keywords"></i> {{ trans('messages.keywords_listing') }}</span>
        </h1>
    </div>
@endsection

@section('page_header')

    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="">{{ trans('messages.home') }}</a></li>
        </ul>
        <h1>
            <span class="text-semibold"><span class="material-symbols-rounded">format_list_bulleted</span> {{ trans('messages.keywords') }}</span>
        </h1>
    </div>

@endsection

@section('content')
    <div class="listing-form"
        sort-url="{{ action('KeywordController@index') }}"
        data-url="{{ action('KeywordController@index') }}"
        per-page="{{ Acelle\Model\Keyword::$itemsPerPage }}">

        <div class="d-flex top-list-controls top-sticky-content">
            <div class="me-auto">
                @if ($keywords->count() >= 0)
                    <div class="filter-box">
                        <span class="filter-group">
                            <span class="title text-semibold text-muted">{{ trans('messages.sort_by') }}</span>
                            <select class="select" name="sort_order">
                                <option value="keywords.created_at">{{ trans('messages.created_at') }}</option>
                                <option value="keywords.updated_at">{{ trans('messages.updated_at') }}</option>
                            </select>
                            <input type="hidden" name="sort_direction" value="desc" />
                            <button type="button" class="btn btn-xs sort-direction" data-popup="tooltip" title="{{ trans('messages.change_sort_direction') }}" role="button" class="btn btn-xs">
                            <span class="material-symbols-rounded desc">sort</span>
                            </button>
                        </span>
                        <span class="text-nowrap">
                            <input type="text" name="keyword" class="form-control search" value="{{ request()->keyword }}" placeholder="{{ trans('messages.type_to_search') }}" />
                            <span class="material-symbols-rounded">search</span>
                        </span>
                    </div>
                @endif
            </div>
        </div>

        
    </div>

    <div class="row">
        @if ($keywords->count() > 0)
        <table class="table table-box pml-table mt-2"
        current-page="{{ empty(request()->page) ? 1 : empty(request()->page) }}"
    >
        @foreach ($keywords as $keyword)
            <tr class="position-relative">
                <td width="1%" class="list-check-col">
                    <img width="50" class="rounded-circle me-2" src="{{ $keyword->user->getProfileImageUrl() }}" alt="">
                </td>
                <td>
                    <h5 class="m-0 text-bold">
                        <a class="kq_search d-block" href="">Keyword:{{ $keyword->keyword }}</a>
                    </h5>
                    <span class="text-muted kq_search">{{ trans('messages.keyword_ranking') }}:{{ $keyword->ranking }}</span><br>
                    <span class="text-muted kq_search">{{ trans('messages.keyword_difficulty') }}:{{ $keyword->difficulty }}</span><br>
                    <span class="text-muted">{{ trans('messages.created_at') }}:{{ $keyword->formatDateTime('date_time') }}
                    </span>
                    <br />
                    <span class="text-muted2"></span>
                </td>
                <td>
                    <span class="text-muted2 list-status pull-left">
                    @if ($keyword->status == 1)
                        <span class="badge bg-success">{{ trans('messages.active') }}</span>
                    @else
                        <span class="badge bg-secondary">{{ trans('messages.inactive') }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
            </table>
            @include('elements/_per_page_select', ["items" => $keywords])
        @else
            <div class="empty-list">
                <span class="material-symbols-rounded">search_off</span>
                <span class="line-1">{{ trans('messages.no_keywords_found') }}</span>
            </div>
        @endif
    </div>
@endsection

