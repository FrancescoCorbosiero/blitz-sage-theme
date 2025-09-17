<?php
class ContactFormValidator {
    public static function rules() {
        return [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'message' => 'required|min:10|max:1000',
            'privacy' => 'accepted'
        ];
    }
}