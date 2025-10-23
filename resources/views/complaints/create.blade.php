<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h4 class="mb-4">Submit a New Complaint</h4>

    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required onchange="toggleEventList()">
                <option value="">-- Select Type --</option>
                <option value="payment process">Payment Process</option>
                <option value="event">Event</option>
                <option value="posting">Posting</option>
                <option value="website">Website</option>
                <option value="store">Store</option>
            </select>
        </div>

        <div class="mb-3" id="eventSelectContainer" style="display: none;">
            <label for="event_id" class="form-label">Select Event</label>
            <select name="event_id" id="event_id" class="form-select">
                <option value="">-- Choose an Event --</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Optional Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100">Send Complaint</button>
    </form>
</body>
</html>
<script>
function toggleEventList() {
    const typeSelect = document.getElementById('type');
    const eventSelectContainer = document.getElementById('eventSelectContainer');
    if (typeSelect.value === 'event') {
        eventSelectContainer.style.display = 'block';
    } else {
        eventSelectContainer.style.display = 'none';
    }
}
</script>