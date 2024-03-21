<?php

namespace Moneroo\Payment;

final class Status
{
    /**
     * The payment has been initiated.
     * This is a transactional state and will change.
     */
    public const INITIATED = 'initiated';

    /**
     * The payment is pending.
     * This is a transactional state and will change.
     */
    public const PENDING = 'pending';

    /**
     * The payment has failed.
     * This is a final state.
     */
    public const FAILED = 'failed';

    /**
     * The payment has been a success.
     * This is a final state.
     */
    public const SUCCESS = 'success';

    /**
     * The payment has been cancelled by user or abandoned (5 minutes after initiated state).
     * Should be treated as a failed payment.
     * This is a final state.
     */
    public const CANCELLED = 'cancelled';
}
