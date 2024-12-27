<?php
//app/Providers/AuthServiceProvider.php
namespace Acelle\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;  // Ensure you import the Gate facade
use Acelle\Model\Setting;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Acelle\Model' => 'Acelle\Policies\ModelPolicy',
        \Acelle\Model\User::class => \Acelle\Policies\UserPolicy::class,
        \Acelle\Model\Contact::class => \Acelle\Policies\ContactPolicy::class,
        \Acelle\Model\MailList::class => \Acelle\Policies\MailListPolicy::class,
        \Acelle\Model\Subscriber::class => \Acelle\Policies\SubscriberPolicy::class,
        \Acelle\Model\Segment::class => \Acelle\Policies\SegmentPolicy::class,
        \Acelle\Model\Layout::class => \Acelle\Policies\LayoutPolicy::class,
        \Acelle\Model\Template::class => \Acelle\Policies\TemplatePolicy::class,
        \Acelle\Model\Campaign::class => \Acelle\Policies\CampaignPolicy::class,
        \Acelle\Model\SendingServer::class => \Acelle\Policies\SendingServerPolicy::class,
        \Acelle\Model\BounceHandler::class => \Acelle\Policies\BounceHandlerPolicy::class,
        \Acelle\Model\FeedbackLoopHandler::class => \Acelle\Policies\FeedbackLoopHandlerPolicy::class,
        \Acelle\Model\SendingDomain::class => \Acelle\Policies\SendingDomainPolicy::class,
        \Acelle\Model\Language::class => \Acelle\Policies\LanguagePolicy::class,
        \Acelle\Model\CustomerGroup::class => \Acelle\Policies\CustomerGroupPolicy::class,
        \Acelle\Model\Customer::class => \Acelle\Policies\CustomerPolicy::class,
        \Acelle\Model\AdminGroup::class => \Acelle\Policies\AdminGroupPolicy::class,
        \Acelle\Model\Admin::class => \Acelle\Policies\AdminPolicy::class,
        \Acelle\Model\Setting::class => \Acelle\Policies\SettingPolicy::class,
        \Acelle\Model\PlanGeneral::class => \Acelle\Policies\PlanPolicy::class,
        \Acelle\Model\Currency::class => \Acelle\Policies\CurrencyPolicy::class,
        \Acelle\Model\Subscription::class => \Acelle\Policies\SubscriptionPolicy::class,
        \Acelle\Model\EmailVerificationServer::class => \Acelle\Policies\EmailVerificationServerPolicy::class,
        \Acelle\Model\Blacklist::class => \Acelle\Policies\BlacklistPolicy::class,
        \Acelle\Model\SubAccount::class => \Acelle\Policies\SubAccountPolicy::class,
        \Acelle\Model\Sender::class => \Acelle\Policies\SenderPolicy::class,
        \Acelle\Model\Automation2::class => \Acelle\Policies\Automation2Policy::class,
        \Acelle\Model\TrackingDomain::class => \Acelle\Policies\TrackingDomainPolicy::class,
        \Acelle\Model\Plugin::class => \Acelle\Policies\PluginPolicy::class,
        \Acelle\Model\Source::class => \Acelle\Policies\SourcePolicy::class,
        \Acelle\Model\Invoice::class => \Acelle\Policies\InvoicePolicy::class,
        \Acelle\Model\Keyword::class => \Acelle\Policies\KeywordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define the 'viewKeywords' gate
        Gate::define('viewKeywords', function ($user, $customer) {
            // Adjust this logic based on your business requirements
            // Example: Check if the logged-in user's customer ID matches the target customer's ID
            return $user->customer->id === $customer->id;
        });
    }
}
