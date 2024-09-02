<div class="container">
    <div class="col-md-12">
        <div class="form-appl">
        <form class="form1" method="post" action="{{ route('user.store') }}" enctype="multipart/form-data">
@csrf
<div class="form-group col-md-12 mb-5">
    <label for="">Photo</label>
    <div class="avatar-upload">
        <div>
            <input type="file" id="imageUpload" name="profile_image" accept=".png, .jpg, .jpeg" onchange="previewImage(this)" />
            <label for="imageUpload"></label>
        </div>
        <div class="avatar-preview">
            <div id="imagePreview" style="background-image : url('{{ url('/img/avatar.jpg') }}')"></div>
        </div>
    </div>
</div>

<input type="submit" class="btn btn-primary" value="Submit">
</form>
        </div>
    </div>
</div>
@push('js')
<script type="text/javascript">
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").css('background-image', 'url(' + e.target.result + ')');
                $("#imagePreview").hide();
                $("#imagePreview").fadeIn(700);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
<style>
    .avatar-upload {
        position: relative;
        max-width: 205px;
    }

    .avatar-upload .avatar-preview {
        width: 67%;
        height: 147px;
        position: relative;
        border-radius: 3%;
        border: 6px solid #F8F8F8;
    }

    .avatar-upload .avatar-preview>div {
        width: 100%;
        height: 100%;
        border-radius: 3%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>


