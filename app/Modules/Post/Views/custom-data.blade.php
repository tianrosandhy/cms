@foreach($data as $row)
<div class="bg-white mb-3 custom-post-item">
    <div class="image-container">
        {!! $row['image'] !!}
    </div>
    <div class="text-container">
        <h5 class="card-title">{{ $row['title'] }}</h5>
        <p class="card-text"><small class="text-muted">{{ $row['author'] ?? 'Anonym' }}</small></p>
        <p class="card-text">{{ $row['excerpt'] }} Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem cupiditate maiores sint ratione tempora. Quia atque qui sapiente consectetur doloribus. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatum temporibus tempora excepturi reprehenderit eveniet quam quisquam fugit ratione distinctio. Nobis?</p>
        {!! $row['action'] !!}
    </div>
</div>
@endforeach