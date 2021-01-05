<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use DataTables;
use Session;
use File;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        //
        if (\Auth::user()->can('manage-option')) {
            # code...
            $option = Option::options();
            return view('option.index', compact('option'));
        } else {
            # code...
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (\Auth::user()) {

            if ($request->logo) {
                $request->validate(
                    [
                        'logo' => 'image|mimes:png',
                    ]
                );

                $logoName = 'logo.png';
                $option     = $request->file('logo')->storeAs('public/logo/', $logoName);
            }
            if ($request->small_logo) {
                $request->validate(
                    [
                        'small_logo' => 'image|mimes:png',
                    ]
                );
                $smallLogoName = 'small_logo.png';
                $option          = $request->file('small_logo')->storeAs('public/logo/', $smallLogoName);
            }
            if ($request->favicon) {
                $request->validate(
                    [
                        'favicon' => 'image|mimes:png',
                    ]
                );
                $favicon = 'favicon.png';
                $option    = $request->file('favicon')->storeAs('public/logo/', $favicon);
            }

            if (!empty($request->title_text) || !empty($request->footer_text)) {
                $post = $request->all();
                unset($post['_token']);
                foreach ($post as $key => $data) {
                    \DB::insert(
                        'insert into options (`option_value`, `option_name`) values (?, ?) ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`) ',
                        [
                            $data,
                            $key,
                        ]
                    );
                }
            }

            return redirect()->back()->with('success', 'Options successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function saveCompany(Request $request)
    {
        //
        if (\Auth::user('create-option')) {
            // $user = \Auth::user();
            $request->validate(
                [
                    'company_name' => 'required|string|max:50',
                    'company_email' => 'required',
                ]
            );
            $post = $request->all();
            unset($post['_token']);

            foreach ($post as $key => $data) {
                \DB::insert(
                    'insert into options (`option_value`, `option_name`) values (?, ?) ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`) ',
                    [
                        $data,
                        $key,
                    ]
                );
            }
            return redirect()->back()->with('success', __('Options successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function saveEmail(Request $request)
    {
        //
        if (\Auth::user()->can('manage-email')) {
            $request->validate(
                [
                    'mail_driver' => 'required|string|max:50',
                    'mail_host' => 'required|string|max:50',
                    'mail_port' => 'required|string|max:50',
                    'mail_username' => 'required|string|max:50',
                    'mail_password' => 'required|string|max:50',
                    'mail_encryption' => 'required|string|max:50',
                    'mail_from_address' => 'required|string|max:50',
                    'mail_from_name' => 'required|string|max:50',
                ]
            );

            $arrEnv = [
                'MAIL_DRIVER' => $request->mail_driver,
                'MAIL_HOST' => $request->mail_host,
                'MAIL_PORT' => $request->mail_port,
                'MAIL_USERNAME' => $request->mail_username,
                'MAIL_PASSWORD' => $request->mail_password,
                'MAIL_ENCRYPTION' => $request->mail_encryption,
                'MAIL_FROM_NAME' => $request->mail_from_name,
                'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            ];
            Option::setEnvironmentValue($arrEnv);

            return redirect()->back()->with('success', __('Email successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function saveSosmed(Request $request, Option $option)
    {
        //
        if (\Auth::user('edit-option')) {
            // $user = \Auth::user();
            $request->validate(
                [
                    'company_fb' => 'required|string|max:50',
                    'company_ig' => 'required',
                ]
            );
            $post = $request->all();
            unset($post['_token']);

            foreach ($post as $key => $data) {
                \DB::insert(
                    'insert into options (`option_value`, `option_name`) values (?, ?) ON DUPLICATE KEY UPDATE `option_value` = VALUES(`option_value`) ',
                    [
                        $data,
                        $key,
                    ]
                );
            }
            return redirect()->back()->with('success', __('Options successfully updated.'));
        } else {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        //
    }
}
