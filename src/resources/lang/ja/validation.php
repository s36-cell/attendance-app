<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'accepted' => ':attributeを承認してください。',
    'active_url' => ':attributeは有効なURLではありません。',
    'after' => ':attributeには:dateより後の日付を指定してください。',
    'after_or_equal' => ':attributeには:date以降の日付を指定してください。',
    'alpha' => ':attributeにはアルファベットのみ使用できます。',
    'alpha_dash' => ':attributeには英数字、ハイフン、アンダースコアのみ使用できます。',
    'alpha_num' => ':attributeには英数字のみ使用できます。',
    'array' => ':attributeには配列を指定してください。',
    'before' => ':attributeには:dateより前の日付を指定してください。',
    'before_or_equal' => ':attributeには:date以前の日付を指定してください。',
    'between' => [
        'numeric' => ':attributeは:minから:maxの間で指定してください。',
        'file' => ':attributeは:min〜:maxKBのファイルで指定してください。',
        'string' => ':attributeは:min〜:max文字で指定してください。',
        'array' => ':attributeは:min〜:max個で指定してください。',
    ],
    'boolean' => ':attributeにはtrueかfalseを指定してください。',
    'confirmed' => ':attributeと一致しません。',
    'date' => ':attributeには正しい日付を指定してください。',
    'email' => 'メールアドレスの形式が正しくありません。',
    'filled' => ':attributeを入力してください。',
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'numeric' => ':attributeには数字を指定してください。',
    'required' => ':attributeを入力してください。',
    'same' => ':attributeと一致しません。',
    'string' => ':attributeには文字列を指定してください。',
    'unique' => 'この:attributeは既に登録されています。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines（★最重要）
    |--------------------------------------------------------------------------
    */

    'custom' => [

        // ===== 会員登録（US001 / FN003） =====
        'name' => [
            'required' => 'お名前を入力してください',
        ],

        'email' => [
            'required' => 'メールアドレスを入力してください',
            'email'    => 'メールアドレスの形式が正しくありません',
            'unique'   => 'このメールアドレスは既に登録されています',
        ],

        'password' => [
            'required' => 'パスワードを入力してください',
            'min'      => 'パスワードは8文字以上で入力してください',
        ],

        'password_confirmation' => [
            'same' => 'パスワードと一致しません',
        ],

        // ===== ログイン（FN009） =====
        'login' => [
            'email.required'    => 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => '確認用パスワード',
    ],

];