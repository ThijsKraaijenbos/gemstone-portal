@vite(['resources/css/app.css'])


@foreach($testData as $test)
<div class="bg-red-500 p-10 mb-5">
    <h1>{{ $test->name }}</h1>
    <p>{{ $test->description ?? "No Description Yet" }}</p>
</div>
@endforeach
