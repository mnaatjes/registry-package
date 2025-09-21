<?php

/**
 * Default Service Registry Categories
 *
 * This file contains the default categories provided by the registry package.
 * An application can override these and add its own by creating a
 * 'categories.php' file in its own config directory.
 */
return [
    'App' => 'General application settings like environment, debug mode, URL, and timezone.',
    'Database' => 'Configuration for all database connections, including drivers, hosts, and credentials.',
    'Cache' => 'Settings for all caching stores, such as Redis, Memcached, or file-based caches.',
    'Services' => 'Credentials and connection settings for third-party services (e.g., Stripe, Mailgun, AWS S3).',
    'Filesystem' => 'Configuration for storage disks, defining public, private, and temporary file locations.',
    'Logging' => 'Defines logging channels, severity levels, and output destinations.',
    'Mail' => 'Settings for all mailer transports, such as SMTP or Sendmail, including credentials.',
    'Security' => 'Configuration related to application security, such as CORS policies, CSP headers, and secret keys.',
    'Session' => 'Configuration for session management, including driver, lifetime, and cookie settings.',
];
