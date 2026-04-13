<h1>Create Survey</h1>

<form action="{{ route('admin.surveys.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Topic Name:</label>
    <input type="text" name="topic_name" required><br><br>

    <label>CSV File:</label>
    <input type="file" name="csv_file" required><br><br>

    <button type="submit">Upload Survey</button>
</form>