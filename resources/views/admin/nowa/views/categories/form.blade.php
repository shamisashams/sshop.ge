<?php
$_checked = ($category and $category->parent_id == null) ? ' checked':'';

$traverse = function ($categories, $prefix = '-') use (&$traverse,$category) {

        //dd($categories);


    $html = '<ul style="margin: initial !important;padding: initial !important;">';

    foreach ($categories as $_category) {
        $checked = ($category and $_category->id == $category->parent_id) ? 'checked':'';
        $html .= '<li style="margin-bottom: 5px"><label class="rdiobox">
                        <input type="radio" name="parent_id" data-checkboxes="mygroup" class="custom-control-input" '. $checked .' id="'.$_category->id.'" value="'.$_category->id.'">
                        <span style="margin-left: 15px">'.$_category->title.'</span>

                        </label></li>';


        if(count($_category->children)){
            $html .= '<li style="padding-left: 20px">';
            $html .= $traverse($_category->children, $prefix.'-');
            $html .= '</li>';
        }

    }

    $html .= '</ul>';

    return $html;
};

?>
@extends('admin.nowa.views.layouts.app')

@section('styles')

    <!--- Internal Select2 css-->
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">

    <!---Internal Fileupload css-->
    <link href="{{asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <!---Internal Fancy uploader css-->
    <link href="{{asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/sumoselect/sumoselect.css')}}">

    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{asset('assets/plugins/telephoneinput/telephoneinput.css')}}">

    <link rel="stylesheet" href="{{asset('uploader/image-uploader.css')}}">

@endsection

@section('content')

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{$category->created_at ? __('admin.category-update') : __('admin.category-create')}}</span>
        </div>
        <div class="justify-content-center mt-2">
            @include('admin.nowa.views.layouts.components.breadcrump')
        </div>
    </div>
    <!-- /breadcrumb -->
    <input name="old-images[]" id="old_images" hidden disabled value="{{$category->files}}">
    <!-- row -->
    {!! Form::model($category,['url' => $url, 'method' => $method,'files' => true]) !!}
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6 class="card-title mb-1">@lang('admin.productcatergories')</h6>
                    </div>
                    <div class="mb-4">
                        <p class="mg-b-10">@lang('admin.catparent')</p>

                        <ul>
                            <li style="margin-bottom: 5px"><label class="rdiobox">
                                    <input type="radio" name="parent_id" data-checkboxes="mygroup" class="custom-control-input" <?=$_checked;?> value="0">
                                    <span style="margin-left: 15px">-none-</span>

                                </label></li>
                            <li>
                                <ul>
                                    <li>
                                        <?=$traverse($categories);?>
                                    </li>
                                </ul>

                            </li>
                        </ul>

                    </div>
                    <div class="mb-4">
                        <p class="mg-b-10">@lang('admin.title')</p>
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        @foreach(config('translatable.locales') as $locale)
                                            <?php
                                            $active = '';
                                            if($loop->first) $active = 'active';
                                            ?>

                                            <li><a href="#lang-{{$locale}}" class="nav-link {{$active}}" data-bs-toggle="tab">{{$locale}}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    @foreach(config('translatable.locales') as $locale)

                                        <?php
                                        $active = '';
                                        if($loop->first) $active = 'active';
                                        ?>
                                        <div class="tab-pane {{$active}}" id="lang-{{$locale}}">
                                            <div class="form-group">
                                                <input type="text" name="{{$locale.'[title]'}}" class="form-control" placeholder="@lang('admin.title')" value="{{$category->translate($locale)->title ?? ''}}">
                                            </div>
                                            @error($locale.'.title')
                                            <small class="text-danger">
                                                <div class="error">
                                                    {{$message}}
                                                </div>
                                            </small>
                                            @enderror
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="form-label">@lang('admin.slug')</label>
                        <input type="text" name="slug" class="form-control" placeholder="@lang('admin.slug')" value="{{$category->slug ?? ''}}">
                    </div>
                    @error('slug')
                    <small class="text-danger">
                        <div class="error">
                            {{$message}}
                        </div>
                    </small>
                    @enderror
                    <div class="form-group mb-0 justify-content-end">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" name="status" class="custom-control-input" id="checkbox-2" {{$category->status ? 'checked' : ''}}>
                                <label for="checkbox-2" class="custom-control-label mt-1">{{__('admin.status')}}</label>
                            </div>
                        </div>
                    </div>

                    @if($category->isRoot())
                    <div class="form-group mb-0 justify-content-end">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" name="on_page" class="custom-control-input" id="checkbox-corner" {{$category->on_page ? 'checked' : ''}}>
                                <label for="checkbox-corner" class="custom-control-label mt-1">{{__('admin.show_on_page')}}</label>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{--<div class="form-group mb-0 justify-content-end">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" name="size" class="custom-control-input" id="checkbox-size" {{$category->size ? 'checked' : ''}}>
                                <label for="checkbox-size" class="custom-control-label mt-1">{{__('admin.size')}}</label>
                            </div>
                        </div>
                    </div>--}}

                    {{--<div class="form-group mb-0 justify-content-end">
                        <div class="checkbox">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" name="color" class="custom-control-input" id="checkbox-color" {{$category->color ? 'checked' : ''}}>
                                <label for="checkbox-color" class="custom-control-label mt-1">{{__('admin.color')}}</label>
                            </div>
                        </div>
                    </div>--}}
                    <?php
                    $attrs = [
                        'corner_size_color' => 'Corner & Size & Color',
                        'corner_color' => 'Corner & Color',
                        'size_color' => 'Size & Color',
                        'size' => 'Size',
                        'color' => 'Color'
                    ];
                    $sel_a = null;
                    if($category->corner == 1 && $category->color == 1 && $category->size == 0){
                        $sel_a = 'corner_color';
                    }
                    if($category->corner == 0 && $category->color == 0 && $category->size == 1){
                        $sel_a = 'size';
                    }
                    if($category->corner == 0 && $category->color == 1 && $category->size == 0){
                        $sel_a = 'color';
                    }
                    if($category->corner == 0 && $category->color == 1 && $category->size == 1){
                        $sel_a = 'size_color';
                    }
                    if($category->corner == 1 && $category->color == 1 && $category->size == 1){
                        $sel_a = 'corner_size_color';
                    }
                    ?>

                    {{--<div class="form-group">
                        <label class="form-label">@lang('admin.fiter_attributes')</label>
                        <select class="form-control" name="filter">
                            <option value="">--none--</option>
                            @foreach($attrs as $k => $attr)
                                <option value="{{$k}}" {{$k == $sel_a ? 'selected':''}}>{{$attr}}</option>
                            @endforeach
                        </select>
                    </div>--}}

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            {!! Form::submit($category->created_at ? __('admin.update') : __('admin.create'),['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- /row -->
    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-images"></div>
                    @if ($errors->has('images'))
                        <span class="help-block">
                                            {{ $errors->first('images') }}
                                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- /row -->

    <!-- row -->

    <!-- row closed -->
    {!! Form::close() !!}

    @if($category->created_at)
    {{--<div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <div class="main-content-label mg-b-5">
                            @lang('admin.colors')
                            <div class="form-group">
                                <a class="btn btn-success" href="{{route('category.add-color',$category)}}">@lang('admin.add_colors')</a>
                            </div>

                            <table class="table">
                                <tr>
                                    <th>id</th>
                                    <th>color</th>
                                    <th></th>
                                </tr>
                                @foreach($category->colors as $color)
                                    <tr>
                                        <td>{{$color->id}}</td>
                                        <td style="background-color: {{$color->color}}">{{$color->color}}</td>
                                        <td>
                                            <a href="{{locale_route('category.edit_color',[$category,$color->id])}}"
                                               class="pl-3">
                                                <i class="fa fa-edit">შეცვლა</i>
                                            </a>
                                            <a href="{{locale_route('category.delete_color',[$category,$color->id])}}"
                                               onclick="return confirm('Are you sure?')" class="pl-3">
                                                <i class="fa fa-edit">წაშლა</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    @endif

@endsection

@section('scripts')

    <!--Internal  Datepicker js -->
    <script src="{{asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

    <!-- Internal Select2 js-->
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <!--Internal Fileuploads js-->
    <script src="{{asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

    <!--Internal Fancy uploader js-->
    <script src="{{asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

    <!--Internal  Form-elements js-->
    <script src="{{asset('assets/js/advanced-form-elements.js')}}"></script>
    <script src="{{asset('assets/js/select2.js')}}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <!-- Internal TelephoneInput js-->
    <script src="{{asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
    <script src="{{asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

    <script src="{{asset('uploader/image-uploader.js')}}"></script>

    <script>
        let oldImages = $('#old_images').val();
        if (oldImages) {
            oldImages = JSON.parse(oldImages);
        }
        let imagedata = [];
        let getUrl = window.location;
        let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
        if (oldImages && oldImages.length > 0) {
            oldImages.forEach((el, key) => {
                let directory = '';
                if (el.fileable_type === 'App\\Models\\Project') {
                    directory = 'project';
                }
                imagedata.push({
                    id: el.id,
                    src: `${baseUrl}${el.path}/${el.title}`
                })
            })
            $('.input-images').imageUploader({
                preloaded: imagedata,
                imagesInputName: 'images',
                preloadedInputName: 'old_images'
            });
        } else {
            $('.input-images').imageUploader();
        }
    </script>

@endsection
