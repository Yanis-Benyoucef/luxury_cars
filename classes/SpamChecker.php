<?php

require_once __DIR__ . '/Email.php';

class SpamChecker
{
    private const SPAM_DOMAINS = ['test.com', 'coucou.fr'];

    public function isSpam(Email $email): bool
    {
        return in_array($email->getDomain(), self::SPAM_DOMAINS);
    }
}