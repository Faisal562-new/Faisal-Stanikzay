<!-- 
  Place this inside your dashboard view file (e.g., resources/views/dashboard.blade.php).
  Make sure Bootstrap CSS/JS are included in your layout file or added here.
-->

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <!-- Success Flash Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 2 & 3. Book Registration Form -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white font-weight-bold">
                    Register a New Book
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        
                        <!-- Title Field -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Author Field -->
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" 
                                   class="form-control @error('author') is-invalid @enderror" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author') }}">
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pages Field -->
                        <div class="mb-3">
                            <label for="pages" class="form-label">Pages</label>
                            <input type="number" 
                                   class="form-control @error('pages') is-invalid @enderror" 
                                   id="pages" 
                                   name="pages" 
                                   value="{{ old('pages') }}">
                            @error('pages')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">Register Book</button>
                    </form>
                </div>
            </div>

            <!-- 3. My Books Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white font-weight-bold">
                    My Books
                </div>
                <div class="card-body">
                    @if($books->isEmpty())
                        <div class="text-center py-3">
                            <p class="text-muted mb-0">Your reading list is currently empty. Add your first book above!</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 10%">No.</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th style="width: 15%">Pages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $index => $book)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            <td>{{ $book->pages }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
