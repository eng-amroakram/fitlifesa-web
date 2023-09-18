<?php


if (!function_exists('apiRules')) {

    function apiRules($form, $id = "")
    {
        if ($form == "register") {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'phone' => 'required|string|max:9|min:9|unique:users,phone,' . $id,
                'password' => 'required|string',
            ];
        }

        if ($form == "login") {
            return [
                'phone' => 'required|string|max:9|min:9|exists:users,phone',
                'password' => 'required|string',
            ];
        }

        if ($form == "verify") {
            return [
                'phone' => 'required|string|max:9|min:9|exists:users,phone',
                'otp_code' => 'required|string|max:5|min:5',
            ];
        }

        if ($form == "updateUser") {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'phone' => 'required|string|max:9|min:9|unique:users,phone,' . $id,
                'image' => 'nullable',
            ];
        }

        if ($form == "changePassword") {
            return [
                'old_password' => 'required',
                'new_password' => 'required|min:8',
            ];
        }

        if ($form == "resendSmsOtp") {
            return [
                'phone' => 'required|string|max:9|min:9|exists:users,phone',
            ];
        }

        if ($form == "questions") {
            return [
                'gender' => "required|in:male,female",
                'age' => 'required',
                'weight' => 'required',
                'height' => 'required',
                'activity' => 'required|in:low,medium,high,off',
                'goal' => 'required|in:lose,maintain,gain',
                'kg_per_week' => 'required|in:0.5,1',
                'level' => 'required|in:beginner,intermediate,advanced',
            ];
        }

        if ($form == "create-macronutrients-plan") {
            return [
                'carbs_intake' => 'required',
                'fat_intake' => 'required',
                'protein_intake' => 'required',
            ];
        }

        if ($form == 'more-info-body-fat-percentage') {
            return [
                'waist' => 'required',
                'neck' => 'required',
                'hip' => 'required',
            ];
        }
    }
}

if (!function_exists('apiRulesMessages')) {
    function apiRulesMessages($form)
    {
        if ($form == "register" || $form == "login" || $form == "verify") {
            return [
                'name.required' => __('This field is required'),
                'gender.required' => __('This field is required'),
                'name.string' => __('Name must be string'),
                'name.max' => __('Name must be less than 255 characters'),
                'email.required' => __('This field is required'),
                'email.string' => __('Email must be string'),
                'email.email' => __('Email must be valid email'),
                'email.max' => __('Email must be less than 255 characters'),
                'email.unique' => __('Email must be unique'),
                'phone.required' => __('This field is required'),
                'phone.string' => __('Phone must be string'),
                'phone.max' => __('Phone must be 9 numbers'),
                'phone.min' => __('Phone must be 9 numbers'),
                'phone.exists' => __('Phone Number is not exists'),
                'phone.unique' => __('Phone must be unique'),
                'type.required' => __('This field is required'),
                'type.in' => __('Type must be one of the following: :values', ['values' => 'admin,coach,client']),
                'password.required' => __('This field is required'),
                'password.string' => __('Password must be string'),
            ];
        }

        if ($form == "changePassword") {
            return [
                'old_password.required' => __('This field is required'),
                'new_password.required' => __('This field is required'),
                'new_password.min' => __('Password must be at least 8 characters'),
            ];
        }

        if ($form == "updateUser") {
            return [
                'name.required' => __('This field is required'),
                'name.string' => __('Name must be string'),
                'name.max' => __('Name must be less than 255 characters'),
                'email.required' => __('This field is required'),
                'email.string' => __('Email must be string'),
                'email.email' => __('Email must be valid email'),
                'email.max' => __('Email must be less than 255 characters'),
                'email.unique' => __('Email must be unique'),
                'phone.required' => __('This field is required'),
                'phone.string' => __('Phone must be string'),
                'phone.max' => __('Phone must be 9 numbers'),
                'phone.min' => __('Phone must be 9 numbers'),
                'phone.unique' => __('Phone must be unique'),
            ];
        }

        if ($form == "resendSmsOtp") {
            return [
                'phone.required' => __('This field is required'),
                'phone.string' => __('Phone must be string'),
                'phone.max' => __('Phone must be 9 numbers'),
                'phone.min' => __('Phone must be 9 numbers'),
                'phone.exists' => __('Phone Number is not exists'),
            ];
        }

        if ($form == "questions") {
            return [
                "gender.required" => __("This field is required"),
                "age.required" => __("This field is required"),
                "weight.required" => __("This field is required"),
                "height.required" => __("This field is required"),
                "activity.required" => __("This field is required"),
                "goal.required" => __("This field is required"),
                "kg_per_week.required" => __("This field is required"),
                "level.required" => __("This field is required"),
            ];
        }

        if ($form == "create-macronutrients-plan") {
            return [
                "carbs_intake.required" => __("This field is required"),
                "fat_intake.required" => __("This field is required"),
                "protein_intake.required" => __("This field is required"),
            ];
        }

        if ($form == "more-info-body-fat-percentage") {
            return [
                "waist.required" => __("This field is required"),
                "neck.required" => __("This field is required"),
                "hip.required" => __("This field is required"),
            ];
        }
    }
}
