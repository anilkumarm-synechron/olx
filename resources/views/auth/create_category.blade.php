<!-- resources/views/create_category.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Create Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Category Name -->
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" value="{{ old('category_name') }}" required>
        </div>

        <!-- Parent Category Dropdown -->
        <div class="mb-3">
            <label for="parent_category_id" class="form-label">Parent Category</label>
            <select name="parent_category_id" id="parent_category_id" class="form-select">
                <option value="">-- No Parent (Top Level) --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('parent_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Category Image Upload -->
        <div class="mb-3">
            <label for="category_image" class="form-label">Category Image</label>
            <input type="file" name="category_image" id="category_image" accept="image/*" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
</body>
</html>