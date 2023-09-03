<?php

namespace Moneroo\Payment;

final class Status
{
    /**
     * The payment has been initiated.
     * This is transactional state and will change.
     */
    public const INITIATED = 'initiated';

    /**
     * The payment is pending.
     * This is transactional state and will change.
     */
    public const PENDING = 'pending';

    /**
     * The payment has failed.
     * This is final state.
     */
    public const FAILED = 'failed';

    /**
     * The payment has been cancelled.
     * This is final state.
     */
    public const SUCCESS = 'success';

    /**
     * The payment has been cancelled by user or abandoned (10 minutes after initiated state).
     * Should be treated as a failed payment.
     * This is final state.
     */
    public const CANCELLED = 'cancelled';
}
