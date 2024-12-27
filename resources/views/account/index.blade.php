@extends('layouts.core.backend', [
    'menu' => 'keyword',
])
//resources/views/account/index.blade.php
@section('title', trans('messages.keywords'))

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

        <div class="pml-table-container"></div>

    </div>

    <script>
        var assignPlanModal = new IframeModal();

        var KeywordIndex = {
            getList: function() {
                return makeList({
                    url: '{{ action('KeywordController@keywordsListing') }}',
                    container: $('.listing-form'),
                    content: $('.pml-table-container')
                });
            }
        };

        $(document).ready(function() {
            KeywordIndex.getList().load();
        });
    </script>

@endsection
