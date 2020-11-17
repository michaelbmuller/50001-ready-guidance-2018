<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests')
    ->in(__DIR__)
    ->append([__DIR__.'/php-cs-fixer'])
;

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'no_superfluous_phpdoc_tags' => false,
        //'header_comment' => ['header' => $header],
        'binary_operator_spaces' => ['align_double_arrow' => true],
        'concat_space' => ['spacing' => 'one'],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'single_line_comment_style' => ['comment_types' => ['hash']],
    ])
    ->setFinder($finder)
;

return $config;
