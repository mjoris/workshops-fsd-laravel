@if ($formErrors)
    <!-- Display Validation Errors -->
    <!-- Form Error List -->
    <div class="alert alert-danger">
        <strong>Something went wrong.</strong>
        <br><br>
        <ul>
            @foreach ($formErrors as $formError)
                <li>{{ $formError }}</li>
            @endforeach
        </ul>
    </div>
@endif
