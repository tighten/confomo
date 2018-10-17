<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('node_modules')
    ->notPath('public')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR1' => false,
        '@PSR2' => true,

        // Logical NOT operators (!) should have one trailing whitespace.
        'not_operator_with_successor_space' => true,
        // PHP multi-line arrays should have a trailing comma.
        'trailing_comma_in_multiline_array' => true,
        // Ordering use statements.
        'ordered_imports' => true,
        // Removes extra blank lines and/or blank lines following configuration.
        'no_extra_blank_lines' => ['use'],
        // An empty line feed should precede a return statement.
        'blank_line_before_return' => true,
        // PHP arrays should be declared using the configured syntax.
        'array_syntax' => ['syntax' => 'short'],
        // Cast (boolean) and (integer) should be written as (bool) and (int), (double) and (real) as (float), (binary) as (string).
        'short_scalar_cast' => true,
        // PHP single-line arrays should not have trailing comma.
        'no_trailing_comma_in_singleline_array' => true,
        // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
        'trim_array_spaces' => true,
        // Binary operators should be surrounded by space as configured.
        'binary_operator_spaces' => ['align_double_arrow' => false, 'align_equals' => false],
        // Unused use statements must be removed.
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
;
