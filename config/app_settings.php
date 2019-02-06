<?php

return [

    // All the sections for the settings page
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.', // (optional)
            'icon' => 'fa fa-cog', // (optional)

            'inputs' => [

                /* Application Name */
                [
                    'name' => 'app_name',                // unique key for setting
                    'type' => 'text',                    // type of input can be text, number, textarea, select, boolean, checkbox etc.
                    'data_type' => 'string',             // data type, string, int, boolean
                    'label' => 'Application Name',               // label for input
                    // optional properties
                    'placeholder' => 'Application Name',       // placeholder for input
                    'class' => 'form-control form-control-sm', // override global input_class
                    'style' => '',                             // any inline styles
                    'rules' => 'required|min:2|max:20',        // validation rules for this input
                    'value' => 'App Name',                             // any default value
                    'hint' => 'You can set the app name here'  // help block text for input
                ],

                /* Application Motto */
                [
                    'name' => 'app_motto', 
                    'type' => 'text', 
                    'data_type' => 'string', 
                    'label' => 'App Motto', 
                    // optional properties
                    'placeholder' => 'Application Motto', 
                    'style' => '', 
                    'rules' => 'nullable|min:5|max:100', 
                    'hint' => 'You can set the app motto here',
                ],

                /* Email address of sent emails */
                [
                    'name' => 'from_email',
                    'type' => 'email',
                    'label' => 'From Email',
                    'placeholder' => 'Application from email',
                    'rules' => 'required|email',
                ],

                /* Name that appear on sent emails */
                [
                    'name' => 'from_name',
                    'type' => 'text',
                    'label' => 'Email from Name',
                    'placeholder' => 'Email from Name',
                ],

                /* Application Support Email */
                [
                    'type' => 'email',
                    'name' => 'app_email',
                    'label' => 'Support Email', 
                    'placeholder' => 'Support Email',
                    'class' => 'form-control form-control-sm',
                    'style' => '', 
                    'rules' => 'nullable|email',
                    'hint' => 'You can set the app support email here'
                ],

                /* Application Support Phone */
                [
                    'type' => 'tel',
                    'name' => 'app_phone',
                    'label' => 'Support Phone', 
                    'placeholder' => 'Support Phone Line',
                    'class' => 'form-control form-control-sm',
                    'style' => '', 
                    'rules' => 'nullable|string|max:50',
                    'hint' => 'You can set the app support phone line here',
                    'required' => 'required',
                ],

                /* Application Support Phone 2 */
                [
                    'type' => 'tel',
                    'name' => 'app_phone_2',
                    'label' => 'Support Phone 2', 
                    'placeholder' => 'Support Phone Line 2',
                    'class' => 'form-control form-control-sm',
                    'style' => '', 
                    'rules' => 'nullable|string|max:50',
                    'hint' => '',
                    'required' => 'required',
                ],

                [
                    'type' => 'select',
                    'name' => 'base_currency',
                    'label' => 'Base Currency',
                    'rules' => 'required',
                    'options' => [
                        'ron' => 'RON',
                        'eur' => 'EUR',
                        'gbp' => 'GBP',
                        'usd' => 'USD',
                    ]
                ],
            ]
        ],

        'subscriptions' => [
            'title' => 'Doctor Subscription Settings',
            'descriptions' => 'Percentage commision and others.',
            'icon' => 'fa fa-rss',

            'inputs' => [/* Base Subscription */
                [
                    'name' => 'base_subscription', //weekly
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> 'Base Subscription Fee (Weekly)',
                    'placeholder' => 'Subscription fee',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:1.00,1000000.00',
                    'step' => '0.01',
                    'min'  => 1.00,
                    'hint' => 'The base subscription amount per week for doctors. Monthly and yearly subscriptions are calculated along with the set discount.'
                ],

                /* Base Discount */
                [
                    'name' => 'base_discount', //weekly
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> 'Base Discount on Subscriptions (%)',
                    'placeholder' => '0.01 - 100',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:1.00,100',
                    'step' => '0.01',
                    'min'  => 0.01,
                    'max'  => 100,
                    'hint' => 'This is the base discount set on subscription fees in the app.'
                ],
                
            ]
        ],

        'appointment_fees' => [
            'title' => 'Appoinment Fee Settings',
            'descriptions' => 'Minimum and maximum fees that can be charged hourly.',
            'icon' => 'fa fa-calendar-alt',

            'inputs' => [/* Base Subscription */

                /* Min Appointment Fee */
                [
                    'name' => 'min_fee',
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> 'Minimum Fee/Hour',
                    'placeholder' => 'Minimum Allowed Fee/Hour',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:1.00,1000000.00',
                    'step' => '0.01',
                    'min'  => 1.00,
                    'hint' => 'Minimum fee that can be charged hourly.'
                ],

                /* Max Appointment Fee */
                [
                    'name' => 'max_fee',
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> 'Maximum Fee/Hour',
                    'placeholder' => 'Maximum Allowed Fee/Hour',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:1.00,1000000.00',
                    'step' => '0.01',
                    'min'  => 1.00,
                    'hint' => 'Maximum fee that can be charged hourly.'
                ],

                /* Admin Appointment Fee Commission */
                [
                    'name' => 'fee_commission',
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> '% Commission (eg 5%)',
                    'placeholder' => '% commission',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:0.00,100.00',
                    'step' => '0.01',
                    'min'  => 0.01,
                    'max'  => 100.00,
                    'hint' => 'Admin Appointment Fee Commission in %.'
                ],

                /* Time to Cancel */
                [
                    'name' => 'booking_countdown',
                    'type' => 'number',
                    'data_type' => 'numeric',
                    'label'=> 'Cancel Booking After (Minutes)',
                    'placeholder' => 'Minutes',
                    'class' => 'form-control form-control-sm', 
                    'style' => '', 
                    'rules' => 'required|between:1,10000',
                    'step' => '1',
                    'min'  => 1,
                    'hint' => 'Time to canceled a booked schedule if patient did not make payment.'
                ]
            ]
        ],

        'more' => [
            'title' => 'More Settings',
            'descriptions' => 'Description of extra app settings.',
            'icon' => 'fa fa-question-mark',

            'inputs' => [
                [
                    'name' => 'extra stuff',
                    'type' => 'text',
                    'label' => 'Extra stuff',
                    'placeholder' => 'extra stuff',
                    'rules' => '',
                ],
            ]
        ]
    ],

    // Setting page url, will be used for get and post request
    'url' => 'settings',

    // Any middleware you want to run on above route
    'middleware' => ['auth','superadmin'],

    // View settings
    'setting_page_view' => 'app_settings::settings_page',
    'flash_partial' => 'app_settings::_flash',

    // Setting section class setting
    'section_class' => 'card mb-3',
    'section_heading_class' => 'card-header p-3 bg-info text-white font-weight-bold',
    'section_body_class' => 'card-body',

    // Input wrapper and group class setting
    'input_wrapper_class' => 'form-group',
    'input_class' => 'form-control form-control-sm',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-muted',
    'input_error_feedback_class' => 'text-danger',

    // Submit button
    'submit_btn_text' => 'Save Settings',
    'submit_success_message' => 'Settings has been saved.',

    // Remove any setting which declaration removed later from sections
    'remove_abandoned_settings' => true,

    // Controller to show and handle save setting
    'controller' => '\QCod\AppSettings\Controllers\AppSettingController',
];
