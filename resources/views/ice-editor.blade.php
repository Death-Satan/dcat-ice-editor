<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label" for="{{$id}}">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="{{$class}}" >
            <textarea id="{{$id}}" name="{{$name}}">
                {!!$value!!}
            </textarea>
        </div>

        @include('admin::form.help-block')

    </div>
</div>
<script>
    ice.editor('{{$id}}',function () {
        let options = {!! $options !!};
        //执行js
        options.hasOwnProperty('loadJs') && eval(options.loadJs);
        //设置上传路径
        this.uploadUrl = options.server;
        let csrf_formData = function (formData) {
            formData.append('_token','{{csrf_token()}}');
            return formData;
        };
        //设置csrf
        this.filesUpload.formData = csrf_formData
        this.imgUpload.formData = csrf_formData
    })
</script>
