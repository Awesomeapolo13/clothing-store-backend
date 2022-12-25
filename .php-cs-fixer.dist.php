<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    // исключаем директории для сканирования на код стайл
    ->exclude(['var', 'vendor'])
;

return (new PhpCsFixer\Config())
    // Установка набора правил для сканирования
    ->setRules([
        // Правила свойственные Symfony
        '@Symfony' => true,
        // Правило, позволяющее писать в снейк кейсе
        'php_unit_method_casing' => [
            'case' => 'snake_case'
        ]
    ])
    ->setFinder($finder)
;
