<?php

declare(strict_types=1);
defined('TYPO3') or die();


$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Plates integration',
    'description' => 'Integration of Plates template system for TYPO3',
    'category' => 'fe',
    'state' => 'alpha',
    'author' => 'Max Frerichs',
    'author_email' => 'typo3@maxfrerichs.dev',
    'author_company' => '',
    'version' => '0.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.6',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
