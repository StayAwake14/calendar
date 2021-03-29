<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
     
<div class="results">
        @if(Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        @if(Session::get('fail'))
            <div class="alert alert-success">
                {{ Session::get('fail') }}
            </div>
        @endif
    </div>
<div class="mx-auto text-center mt-5 mb-5">
<h1 class="text-3xl">Absence Add Form</h1>
    <form action=" {{ route('absence.add') }}" method="post">
    @csrf
        <div class="form-group">
            <label for="reason">Reason</label>
            <select class="form-input px-4 py-3 rounded-full border" type="text" name="reason">
            @foreach($reasons as $reason)
                <option value="{{ $reason['id'] }}"> {{ $reason["reason_name"] }} </option>
            @endforeach
            </select>
            <span class="bg-600-red">@error('reason') {{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="datefrom">Since: </label>
            <input type="date" class="form-input px-4 py-3 rounded-full border"  name="datefrom">
        </div>
        <div class="form-group">
            <label for="datefrom">To: </label>
            <input type="date" class="form-input px-4 py-3 rounded-full border"  name="dateto">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-input px-4 py-3 rounded-full border"  name="description"></textarea>
        </div>
        <div class="form-group">
            <button class="mb-5 py-2 px-4 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none" type="submit">Add</button>
        </div>
    </form>
    <a href="profile" class="mt-5 py-2 px-4 bg-pink-500 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 focus:outline-none">Profile </a>
</div>

</body></html>