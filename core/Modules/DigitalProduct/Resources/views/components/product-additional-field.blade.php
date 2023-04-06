<?php
    if (!isset($authors)) {
        $authors = [];
    }
?>

<div class="general-info-wrapper px-3">
    <h4 class="dashboard-common-title-two"> {{__('Product Additional Field Info')}} </h4>
    <div class="general-info-form mt-0 mt-lg-4">
            <div class="dashboard-input mt-4">
                <label class="dashboard-label color-light mb-2"> {{ __("Author") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
                <select name="author" id="tax" class="form-control">
                    <option value="">{{__('Select an author')}}</option>
                    @foreach($authors as $author)
                        <option value="{{$author->id}}">{{$author->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="dashboard-input mt-4">
                <label class="dashboard-label color-light mb-2"> {{ __("Pages") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
                <input type="text" class="form--control radius-10" value="" name="page"
                       placeholder="{{ __("Enter page number...") }}">
            </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Language") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="language"
                   placeholder="{{ __("Enter written language...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Formats") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="format"
                   placeholder="{{ __("Enter formats...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Words") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="word"
                   placeholder="{{ __("Enter words...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Tool Used") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="tool_used"
                   placeholder="{{ __("Enter tool names...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Database Used") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="database_used"
                   placeholder="{{ __("Enter database names...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Compatible Browsers") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="compatible_browser"
                   placeholder="{{ __("Enter compatible browser names...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("Compatible OS") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <input type="text" class="form--control radius-10" value="" name="compatible_os"
                   placeholder="{{ __("Enter compatible os names...") }}">
        </div>

        <div class="dashboard-input mt-4">
            <label class="dashboard-label color-light mb-2"> {{ __("High Resolution") }} <sup class="text-primary">{{__('(Optional)')}}</sup></label>
            <select name="high_resolution" id="high_resolution" class="form-control">
                <option value="">{{__('Select an option')}}</option>
                <option value="yes">{{__('Yes')}}</option>
                <option value="no">{{__('No')}}</option>
            </select>
        </div>
    </div>

    <h4 class="dashboard-common-title-two mt-5"> {{__('Product Additional Custom Field Info')}} <sup class="text-primary">{{__('(Optional)')}}</sup> </h4>
    <div class="general-info-form mt-0 mt-lg-4">
        <div class="row custom-additional-field-row">
            <div class="col-5">
                <input type="text" class="form--control radius-10" value="" name="option_name[]"
                       placeholder="{{ __("Option Name") }}">
            </div>
            <div class="col-5">
                <input type="text" class="form--control radius-10" value="" name="option_value[]"
                       placeholder="{{ __("Option Value") }}">
            </div>
            <div class="col-2">
                <div class="custom-button d-flex gap-3">
                    <a class="btn btn-info custom-plus" href="javascript:void(0)"><span class="mdi mdi-plus"></span></a>
                    <a class="btn btn-danger custom-minus" href="javascript:void(0)"><span class="mdi mdi-minus"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
