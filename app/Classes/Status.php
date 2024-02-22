<?php

namespace App\Classes;

class Status
{
    public const NEEDS_APPROVAL = 'needs_approval';
    public const APPROVED = 'approved';
    public const CANCELLED = 'cancelled';
    public const ACTIONABLE_VTEX_STATE = 'payment-pending';
}
