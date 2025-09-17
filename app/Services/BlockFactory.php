<?php
class BlockFactory {
    public static function create($type, $data = []) {
        $defaults = config("blocks.{$type}.defaults", []);
        $merged = array_merge($defaults, $data);
        
        return view("sections.{$type}.{$type}", [
            'data' => $merged,
            'id' => uniqid("{$type}-"),
            'classes' => self::getBlockClasses($type, $data)
        ]);
    }
    
    protected static function getBlockClasses($type, $data) {
        return implode(' ', [
            "block-{$type}",
            $data['theme'] ?? '',
            $data['spacing'] ?? 'py-16',
            $data['animation'] ?? ''
        ]);
    }
}