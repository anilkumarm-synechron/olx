<!-- resources/views/create_post.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Create Post</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Post Name -->
        <div class="mb-3">
            <label for="post_name" class="form-label">Post Name</label>
            <input type="text" name="post_name" id="post_name" class="form-control" value="{{ old('post_name') }}" required>
        </div>

        <!-- Post Price -->
        <div class="mb-3">
            <label for="post_price" class="form-label">Post Price</label>
            <input type="number" name="post_price" id="post_price" class="form-control" step="0.01" value="{{ old('post_price') }}" required>
        </div>

        <!-- Category Dropdown -->
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="post_image" class="form-label">Post Image</label>
            <input type="file" name="post_image" id="post_image" accept="image/*" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
</body>
</html>