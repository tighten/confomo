<?php

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'logical_not_operators_with_successor_space',   // Logical NOT operators (!) should have one trailing whitespace.
        'multiline_array_trailing_comma',               // PHP multi-line arrays should have a trailing comma.
        'ordered_use',                                  // Ordering use statements (alphabetically).
        'remove_lines_between_uses',                    // Remove line breaks between use statements.
        'return',                                       // An empty line feed should precede a return statement.
        'short_array_syntax',                           // PHP arrays should use the PHP 5.4 short-syntax.
        'short_scalar_cast',                            // Cast "(boolean)" and "(integer)" should be written as "(bool)" and "(int)". "(double)" and "(real)" as "(float)".
        'single_array_no_trailing_comma',               // PHP single-line arrays should not have a trailing comma.
        'trim_array_spaces',                            // Arrays should be formatted like function/method arguments, without leading or trailing single line space.
        'unalign_double_arrow',                         // Unalign double arrow symbols.
        'unalign_equals',                               // Unalign equals symbols.
        'unused_use',                                   // Unused use statements must be removed.
    ]);
