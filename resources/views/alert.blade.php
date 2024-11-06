@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{{ session()->get('error') }}</li>
        </ul>
    </div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session()->get('success') }}</li>
        </ul>
    </div>
@endif
