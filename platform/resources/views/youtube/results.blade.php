<h3>نتائج البحث عن: {{ $keyword }}</h3>

@foreach($videos as $video)
    <div style="margin: 10px 0;">
        <img src="{{ $video['thumbnail'] }}" alt="Thumbnail">
        <p>{{ $video['title'] }}</p>
        <a href="{{ route('youtube.comments', $video['videoId']) }}">تحليل التعليقات</a>
    </div>
@endforeach
