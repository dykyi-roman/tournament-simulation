<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/..')
    ->in(__DIR__ . '/../Tests')
    ->exclude('config');

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'ordered_imports' => true,
        'declare_strict_types' => true,
        'single_import_per_statement' => false,
        'yoda_style' => true,
        'phpdoc_align' => false,
        'single_trait_insert_per_statement' => false,
        'php_unit_mock' => ['target' => 'newest'],
        'php_unit_namespaced' => ['target' => 'newest'],
        'php_unit_method_casing' => ['case' => 'camel_case'],
        'php_unit_set_up_tear_down_visibility' => true,
    ]);