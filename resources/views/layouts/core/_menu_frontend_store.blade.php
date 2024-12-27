@php $menu = $menu ?? false @endphp

<nav class="navbar navbar-expand-xl navbar-dark fixed-top navbar-main frontend py-0">
    <div class="container-fluid ms-0">
        <a class="navbar-brand d-flex align-items-center me-2" href="{{ action('HomeController@index') }}">
            @if (getLogoMode(Auth::user()->customer->theme_mode, Auth::user()->customer->getColorScheme(), request()->session()->get('customer-auto-theme-mode')) == 'dark')
                <img class="logo" src="{{ getSiteLogoUrl('dark') }}" data-dark="{{ getSiteLogoUrl('dark') }}" data-light="{{ getSiteLogoUrl('light') }}" />
            @else
                <img class="logo" src="{{ getSiteLogoUrl('light') }}" data-dark="{{ getSiteLogoUrl('dark') }}" data-light="{{ getSiteLogoUrl('light') }}" />
            @endif
        </a>
        <button class="navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#mainAppNav" aria-controls="mainAppNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <span middle-bar-control="element" class="leftbar-hide-menu middle-bar-element">
        </span>

        <div class="collapse navbar-collapse" id="mainAppNav">
            <ul class="navbar-nav me-auto mb-md-0 main-menu">
                <li class="nav-item {{ $menu == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ action('HomeController@index') }}" title="{{ trans('messages.dashboard') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                        <i class="navbar-icon">
                        </i>
                        <span>{{ trans('messages.dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ $menu == 'campaign' ? 'active' : '' }}">
                    <a title="{{ trans('messages.campaigns') }}" href="{{ action('CampaignController@index') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                        <i class="navbar-icon">
                        </i>
                        <span>{{ trans('messages.campaigns') }}</span>
                    </a>
                </li>
                @if (Auth::user()->customer->can("list", new Acelle\Model\Automation2()))
                    <li class="nav-item {{ $menu == 'automation' ? 'active' : '' }}">
                        <a href="{{ action('Automation2Controller@index') }}" title="{{ trans('messages.automations') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                            <i class="navbar-icon">
                            </i>
                            <span>{{ trans('messages.automations') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item dropdown {{ in_array($menu, ['overview','list','subscriber','segment','form']) ? 'active' : '' }}">
                    <a href=""
                        title="{{ trans('messages.lists') }}"
                        class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['overview','list','subscriber','segment','form']) ? 'show' : '' }}"
                        data-bs-toggle="dropdown"
                    >
                        <i class="navbar-icon">
                        </i>
                        <span>{{ trans('messages.lists') }}</span>
                    </a>
                    <ul class="dropdown-menu {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['overview','list','subscriber','segment','form']) ? 'show' : '' }}" aria-labelledby="audience-menu">
                        <li class="nav-item {{ $menu == 'overview' ? 'active' : '' }}">
                            <a class="dropdown-item d-flex align-items-center" href="{{ action('AudienceController@overview') }}">
                                <span>{{ trans('messages.audience.overview') }}</span>
                            </a>
                        </li>
                        <li class="nav-item {{ $menu == 'list' ? 'active' : '' }}">
                            <a class="dropdown-item d-flex align-items-center" href="{{ action('MailListController@index') }}">
                                <span>{{ trans('messages.lists') }}</span>
                            </a>
                        </li>
                        @if (Auth::user()->customer->mailLists()->count())
                            <li class="nav-item {{ $menu == 'subscriber' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('SubscriberController@index', [
                                    'list_uid' => Auth::user()->customer->mailLists()->first() ? Auth::user()->customer->mailLists()->first()->uid : null,
                                ]) }}">
                                    <span>{{ trans('messages.contacts') }}</span>
                                </a>
                            </li>
                            @if (Auth::user()->customer->can("list", new Acelle\Model\Segment()))
                                <li class="nav-item {{ $menu == 'segment' ? 'active' : '' }}">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ action('SegmentController@index', [
                                        'list_uid' => Auth::user()->customer->mailLists()->first() ? Auth::user()->customer->mailLists()->first()->uid : null,
                                    ]) }}">
                                        
                                        <span>{{ trans('messages.segments') }}</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item {{ $menu == 'subscriber' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('SubscriberController@noList') }}">
                                    <i class="navbar-icon" style="">
                                    
                                    </i>
                                    <span>{{ trans('messages.contacts') }}</span>
                                </a>
                            </li>
                            @if (Auth::user()->customer->can("list", new Acelle\Model\Segment()))
                                <li class="nav-item {{ $menu == 'segment' ? 'active' : '' }}">
                                    <a class="dropdown-item d-flex align-items-center" href="{{ action('SegmentController@noList') }}">
                                        <i class="navbar-icon" style="">
                                            
                                        </i>
                                        <span>{{ trans('messages.segments') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                        @if (Auth::user()->customer->can("list", new Acelle\Model\Form()))
                            <li class="nav-item {{ $menu == 'form' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('FormController@index') }}">
                                    <i class="navbar-icon" style="">
                                        
                                    </i>
                                    <span>{{ trans('messages.forms') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item {{ $menu == 'template' ? 'active' : '' }}">
                    <a href="{{ action('TemplateController@index') }}" title="{{ trans('messages.templates') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                        <i class="navbar-icon">
                            
                        </i>
                        <span>{{ trans('messages.templates') }}</span>
                    </a>
                </li>

                <li class="nav-item dropdown {{ in_array($menu, ['categories','attributes','media','orders','products','funnels']) ? 'active' : '' }}">
                    <a title="{{ trans('messages.sending') }}" href="{{ action('TemplateController@index') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']) ? 'show' : '' }}" id="sending-menu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="navbar-icon">
                            
                        </i>
                        <span>{{ trans('store.store') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-bottom {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['categories','attributes','media','orders','products','funnels']) ? 'show' : '' }}" aria-labelledby="sending-menu">
                        <li class="nav-item {{ $menu == 'products' ? 'active' : '' }}">
                            <a href="{{ action('Store\ProductController@index') }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon">
                                    
                                </i>
                                <span>{{ trans('store.product') }}</span>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ $menu == 'categories' ? 'active' : '' }}">
                            <a href="{{ action('Store\CategoryController@index') }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon">
                                    
                                </i>
                                <span>{{ trans('store.categories') }}</span>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ $menu == 'attributes' ? 'active' : '' }}">
                            <a href="{{ action('Store\AttributeController@index') }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon">
                                    
                                </i>
                                <span>{{ trans('store.attributes') }}</span>
                            </a>
                        </li>

                        <li class="nav-item {{ $menu == 'orders' ? 'active' : '' }}">
                            <a href="{{ action('Store\OrdersController@index') }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon">
                                    
                                </i>
                                <span>{{ trans('store.orders') }}</span>
                            </a>
                        </li>

                        <li class="nav-item {{ $menu == 'media' ? 'active' : '' }}">
                            <a href="{{ action('Store\MediaController@index') }}"
                                class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon">
                                    
                                </i>
                                <span>{{ trans('store.media') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                @if (config('app.brand') || config('custom.woo'))
                    <li class="nav-item dropdown {{ in_array($menu, ['product','source']) ? 'active' : '' }}">
                        <a title="{{ trans('messages.content') }}"
                            class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['product','source']) ? 'show' : '' }}"
                            id="content-menu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="navbar-icon">
                                
                            </i>
                            <span>{{ trans('messages.content') }}</span>
                        </a>
                        <ul class="dropdown-menu {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['product','source']) ? 'show' : '' }}" aria-labelledby="content-menu">
                            <li class="nav-item {{ $menu == 'product' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('ProductController@index') }}">
                                    <i class="navbar-icon" style="">
                                        
                                    </i>
                                    <span>{{ trans('messages.products') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $menu == 'source' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('SourceController@index') }}">
                                    <i class="navbar-icon" style="">
                                        
                                    </i>
                                    <span>{{ trans('messages.stores_connections') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (
                    Auth::user()->customer->can("read", new Acelle\Model\SendingServer()) ||                    
                    Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->useOwnEmailVerificationServer() ||
                    Auth::user()->customer->can("read", new Acelle\Model\Blacklist()) ||
                    true
                )
                    <li class="nav-item dropdown {{ in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']) ? 'active' : '' }}">
                        <a title="{{ trans('messages.sending') }}" href="{{ action('TemplateController@index') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']) ? 'show' : '' }}" id="sending-menu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="navbar-icon">
                                
                            </i>
                            <span>{{ trans('messages.sending') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-bottom {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']) ? 'show' : '' }}" aria-labelledby="sending-menu">
                            @if (Auth::user()->customer->can("read", new Acelle\Model\SendingServer()))
                                <li class="nav-item {{ $menu == 'sending_server' ? 'active' : '' }}">
                                    <a href="{{ action('SendingServerController@index') }}"
                                        class="dropdown-item d-flex align-items-center">
                                        <i class="navbar-icon" style="width:19px">
                                            
                                    </i> {{ trans('messages.sending_servers') }}
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->customer->allowVerifyingOwnDomains())
                                <li class="nav-item {{ $menu == 'sending_domain' ? 'active' : '' }}" rel1="SendingDomainController">
                                    <a href="{{ action('SendingDomainController@index') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="navbar-icon" style="width:20  px">
                                        
                                        </i> {{ trans('messages.sending_domains') }}
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->allowSenderVerification())
                                <li class="nav-item {{ $menu == 'sender' ? 'active' : '' }}">
                                    <a href="{{ action('SenderController@index') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="navbar-icon" style="width:20  px">
                                        </i> {{ trans('messages.verified_senders') }}
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item {{ $menu == 'tracking_domain' ? 'active' : '' }}">
                                <a href="{{ action('TrackingDomainController@index') }}" class="dropdown-item d-flex align-items-center">
                                <i class="navbar-icon" style="width:20px">
                                    
                                    </i> {{ trans('messages.tracking_domains') }}
                                </a>
                            </li>
                            @if (Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->useOwnEmailVerificationServer())
                                <li class="nav-item {{ $menu == 'email_verification' ? 'active' : '' }}">
                                    <a href="{{ action('EmailVerificationServerController@index') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="navbar-icon" style="width:20px">
                                        
                                    </i> {{ trans('messages.email_verification_servers') }}
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->customer->can("read", new Acelle\Model\Blacklist()))
                                <li class="nav-item {{ $menu == 'blacklist' ? 'active' : '' }}">
                                    <a href="{{ action('BlacklistController@index') }}" class="dropdown-item d-flex align-items-center">
                                    <i class="navbar-icon" style="width:20px">
                                    
                                    </i> {{ trans('messages.blacklist') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                
                @if (Auth::user()->customer->can("list", Acelle\Model\Website::class))
                    <li class="nav-item dropdown {{ in_array($menu, ['website','website_new']) ? 'active' : '' }}">
                        <a href=""
                            class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['website','website_new']) ? 'show' : '' }}"
                            data-bs-toggle="dropdown"
                        >
                            <i class="navbar-icon">
                                
                            </i>
                            <span>{{ trans('messages.intergration') }}</span>
                        </a>
                        <ul class="dropdown-menu {{ request()->session()->get('customer-leftbar-state') != 'closed' && Auth::user()->customer->getMenuLayout() == 'left' && in_array($menu, ['website','website_new']) ? 'show' : '' }}" aria-labelledby="audience-menu">
                            <li class="nav-item {{ $menu == 'website_new' ? 'active' : '' }}">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('WebsiteController@create') }}">
                                    <i class="navbar-icon" style="">
                                        
                                    </i>
                                    <span>{{ trans('messages.website.add_site') }}</span>
                                </a>
                            </li>
                            <li class="nav-item {{ $menu == 'website' ? 'active' : '' }}" rel1="WebsiteController/show">
                                <a class="dropdown-item d-flex align-items-center" href="{{ action('WebsiteController@index') }}">
                                    <i class="navbar-icon" style="">
                                        
                                    </i>
                                    <span>{{ trans('messages.connections.manage') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->customer->canUseApi())
                    <li class="nav-item {{ $menu == 'api' ? 'active' : '' }}">
                        <a href="{{ action("AccountController@api") }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                        <i class="navbar-icon">
                        </i><span>{{ trans('messages.campaign_api') }}</span>
                        </a>
                    </li>
                @endif

                <!-- 24 dec 2024 -->
                    <li class="nav-item {{ $menu }}">
                        <a href="{{ action('AccountController@keywordsListing') }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                            <i class="navbar-icon">
                                <svg style="width:22px;height:22px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 92.6 105.4">
                                    <!-- SVG content -->
                                </svg>
                            </i>
                            <span>{{ trans('messages.keywords') }}</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $menu }}">
                        <a href="{{ action("AccountController@api") }}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1">
                        <i class="navbar-icon">
                        
                        </i><span>{{ trans('messages.keyword_histories') }}</span>
                        </a>
                    </li>
            </ul>
            <div class="navbar-right">
                <ul class="navbar-nav me-auto mb-md-0">
                    @include('layouts.core._top_activity_log')
                    @include('layouts.core._menu_frontend_user')
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>
    var MenuFrontend = {
        saveLeftbarState: function(state) {
            var url = '{{ action('AccountController@leftbarState') }}';

            $.ajax({
                method: "GET",
                url: url,
                data: {
                    _token: CSRF_TOKEN,
                    state: state,
                }
            });
        }
    };

    $(function() {
        //
        $('.leftbar .leftbar-hide-menu').on('click', function(e) {
            if (!$('.leftbar').hasClass('leftbar-closed')) {
                $('.leftbar').addClass('leftbar-closed');

                $('.leftbar').removeClass('state-open');
                $('.leftbar').addClass('state-closed');

                // close menu
                $('#mainAppNav .lvl-1.show').dropdown('hide');

                MenuFrontend.saveLeftbarState('closed');
            } else {
                $('.leftbar').removeClass('leftbar-closed');

                $('.leftbar').removeClass('state-closed');
                $('.leftbar').addClass('state-open');

                // open menu
                if ($('#mainAppNav .nav-item.active .lvl-1').closest('.dropdown').length) {
                    $('#mainAppNav .nav-item.active .lvl-1').dropdown('show');
                }

                MenuFrontend.saveLeftbarState('open');
            }
        });
    });        
</script>
