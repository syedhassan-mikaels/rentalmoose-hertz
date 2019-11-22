<style>
    .w-30{
        width: 30%;
    }
</style>
<div>
    <form action="{{route('upload_car_station')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="file" name="file" />
        <div class="w-30">
            <hr>
            <input type="submit" value="Upload">
        </div>
    </form>
</div>
