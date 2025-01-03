<?php

namespace Acelle\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Acelle\Model\User;
use Acelle\Model\Setting;
use Acelle\Cashier\Cashier;
use Acelle\Model\Subscription;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function approve(User $user, Subscription $subscription, $role)
    {
        switch ($role) {
            case 'admin':
                $can = $subscription->getUnpaidInvoice() &&
                    $subscription->getUnpaidInvoice()->getPendingTransaction() &&
                    $subscription->getUnpaidInvoice()->getPendingTransaction()->allowManualReview();
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }

    public function readAll(User $user, Subscription $subscription, $role)
    {
        switch ($role) {
            case 'admin':
                $can = $user->admin->getPermission('subscription_read') == 'all';
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }

    public function read(User $user, Subscription $subscription, $role)
    {
        switch ($role) {
            case 'admin':
                $can = $user->admin->getPermission('subscription_read') != 'no';
                break;
            case 'customer':
                $can = !$subscription->id || $user->customer->id == $subscription->customer_id;
                break;
        }

        return $can;
    }

    public function disableRecurring(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive() && $subscription->isRecurring();
        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                break;
        }

        return $can;
    }

    public function enableRecurring(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive() && !$subscription->isRecurring() && !$subscription->isEnded();
        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                break;
        }

        return $can;
    }

    public function cancelNow(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive();

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                break;
        }

        return $can;
    }

    public function terminate(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive() || $subscription->isNew();

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                break;
        }

        return $can;
    }

    public function invoices(User $user, Subscription $subscription, $role)
    {
        $can = isset($subscription);

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                break;
        }

        return $can;
    }

    public function changePlan(User $user, Subscription $subscription, $role)
    {
        switch ($role) {
            case 'admin':
                $can = false;
                break;
            case 'customer':
                $can = $subscription->isActive() && !$subscription->getItsOnlyUnpaidChangePlanInvoice();
                break;
        }

        return $can;
    }

    public function rejectPending(User $user, Subscription $subscription, $role)
    {
        switch ($role) {
            case 'admin':
                $can = $subscription->getUnpaidInvoice() &&
                    $subscription->getUnpaidInvoice()->getPendingTransaction() &&
                    $subscription->getUnpaidInvoice()->getPendingTransaction()->allowManualReview();
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }

    public function delete(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isEnded() || $subscription->isTerminated();

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }

    public function replenishSendingCredits(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive();

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }

    public function replenishVerificationCredits(User $user, Subscription $subscription, $role)
    {
        $can = $subscription->isActive();

        switch ($role) {
            case 'admin':
                break;
            case 'customer':
                $can = false;
                break;
        }

        return $can;
    }
}
