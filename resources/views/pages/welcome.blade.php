@extends('layouts.app')

@section('title', '| Inicio')

@section('content')
    <div class="jumbotron">
        <div class="container-lg p-responsive position-relative">
            <div class="d-md-flex flex-items-center gutter-md-spacious">
                <div class="col-md-7 text-md-left ">
                    <h1 class="alt-h0 text-white lh-condensed-ultra mb-3">Built for developers</h1>
                    <p class="alt-lead mb-4">
                        GitHub is a development platform inspired by the way you work. From <a href="/open-source" class="text-white jumbotron-link">open source</a>                    to <a href="/business" class="text-white jumbotron-link">business</a>, you can host and review code,
                        manage projects, and build software alongside millions of other developers.
                    </p>
                </div>
                <div class="mx-auto col-sm-8 col-md-5 hide-sm rounded-1 bg-gray-light pt-4 pb-5">
                    <!-- '"` -->
                    <!-- </textarea></xmp> -->
                    <form>
                        <div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="✓">
                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[login]">Username</label>
                                <input type="text" name="user[login]" id="user[login]" class="form-control form-control-lg input-block" placeholder="Pick a username"
                                    data-autocheck-url="/signup_check/username" data-autocheck-authenticity-token="V9Yq3DyBX1Hb4GgG+JmN/Z/pXTBkdBm2tbqmQZ9nFU8oyNjfYpcgFebxQlIpyHXHHiXT5sYBDenFkeDHPH7kbA=="
                                    autofocus="">
                            </dd>
                        </dl>
                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[email]">Email</label>
                                <input type="text" name="user[email]" id="user[email]" class="form-control form-control-lg input-block js-email-notice-trigger"
                                    placeholder="Your email address" data-autocheck-url="/signup_check/email" data-autocheck-authenticity-token="WlllhryIloqskTt6vArLgj9tpvfDzKA/PeywobbUWiHYjTxSosXKefnZfQUb0mdQH//jDWo5OWTOIoPFpI7S3g==">
                            </dd>
                        </dl>
                        <dl class="form">
                            <dd>
                                <label class="form-label text-gray f5" for="user[password]">Password</label>
                                <input type="password" name="user[password]" id="user[password]" class="form-control form-control-lg input-block" placeholder="Create a password"
                                    data-autocheck-url="/signup_check/password" data-autocheck-authenticity-token="KceAbsk0HbQ4i1PiZYrT+sKeEkNsOrQdYnuzzC0rjKWERVzHmOofiokVihGPzEE58gUehfEVEYbob2HIkIfA+Q==">
                            </dd>
                            <p class="form-control-note">Use at least one letter, one numeral, and seven characters.</p>
                        </dl>
                        <input type="hidden" name="source" class="js-signup-source" value="form-home">
                        <input class="form-control" name="timestamp" type="hidden" value="1499970954659">
                        <input class="form-control" name="timestamp_secret" type="hidden" value="1c02ed4445be76607c36a38de42a612f2e2c322bf83607d1da52d55ede7bac01">

                        <button class="btn btn-primary btn-large f4 btn-block" type="submit">Registrar en 3D Sprint</button>
                    </form>
                </div>
                <div class="d-sm-none text-center">
                    <a href="/join?source=button-home" class="btn btn-primary btn-large border-0" rel="nofollow">Sign up for GitHub</a>
                </div>
            </div>
        </div>
    </div>
@endsection