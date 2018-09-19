<?php

namespace LucLeroy\Strings\CaseTransformer;

class CaseTransformerFactory {
    
    private static $instance = null;
    
    private function __construct() {
    }
    
    /**
     * 
     * @return CaseTransformerFactory
     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function constant($prefixNumberFirst = false) {
        $prefix = $prefixNumberFirst
            ? '_'
            : '';
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_UPPER, null, '_', null, null, null, $prefix);
    }

    public function camel($prefixNumberFirst = false) {
        $prefix = $prefixNumberFirst
            ? '_'
            : '';
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_TITLE, SimpleCaseTransformer::CASE_LOWER, '', '_',
            null, null, $prefix);
    }

    public function pascal($prefixNumberFirst = false) {
        $prefix = $prefixNumberFirst
            ? '_'
            : '';
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_TITLE, null, '', '_', null, null, $prefix);
    }

    public function snake($prefixNumberFirst = false) {
        $prefix = $prefixNumberFirst
            ? '_'
            : '';
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, null, '_', null, null, null, $prefix);
    }

    public function dot() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, null, '.');
    }

    public function header() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_TITLE, null, '-');
    }

    public function lower() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, null, ' ');
    }

    public function upper() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_UPPER, null, ' ');
    }

    public function kebab() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, null, '-');
    }
    
    public function train() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_UPPER, null, '-');
    }

    public function path() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, null, '/');
    }

    public function title() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_TITLE, null, ' ');
    }
    
    public function sentence() {
        return new SimpleCaseTransformer(SimpleCaseTransformer::CASE_LOWER, SimpleCaseTransformer::CASE_TITLE, ' ');
    }

}
