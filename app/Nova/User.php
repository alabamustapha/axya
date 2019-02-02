<?php

namespace App\Nova;

use App\Nova\Actions\MakeAdmin;
use App\Nova\Filters\UserRole;
use App\Nova\Filters\UserVerified;
use App\Nova\Metrics\UsersCount;
use App\Nova\Metrics\UsersTrend;
use App\Nova\Metrics\UsersGenderPartition;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Illuminate\Support\Facades\Storage;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    public function title()
    {
        return $this->name .' - '. $this->type();
    }

    public function subtitle()
    {
        return $this->professionalType() .' - '. $this->status();
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            // ID::make()->sortable(),
            Gravatar::make(),

            // Avatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            Text::make('Gender')
                ->sortable(),

            DateTime::make('Account Verified','email_verified_at')
                // ->hiddenFromIndex()
                ->onlyOnDetail()
                ,

            Select::make('User Type', 'acl')->options([
                    'Admin'=> '1',
                    'Staff'=> '2',
                    'Normal'=> '3',
                ])
                ->onlyOnDetail()
                ,

            Select::make('Blocked')->options([
                    'block'=> 'blocked',
                    'unblock'=> 'unblocked',
                ])
                ->onlyOnDetail()
                ,

            // Avatar::make('Profile Photo')->disk('public'),

            // Image::make('Profile Photo')
            //     ->disk('public')
            //     ->preview(function () {
            //         return $this->avatar
            //                     ? Storage::disk($this->disk)->url($this->avatar)
            //                     : null;
            //     }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new UsersCount,
            new UsersTrend,
            new UsersGenderPartition,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new UserVerified,
            new UserRole,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new MakeAdmin)->canSee(function ($request){
                return $request->user()->isSuperAdmin();
            }),
        ];
    }
}
